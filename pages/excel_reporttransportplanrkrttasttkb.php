<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานประจำเดือน.xls";
} else {
    $strExcelFileName = "รายงานประจำเดือน" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}


$sql_seDate = "SELECT DATENAME(MONTH,'".$_GET['datestart']."') AS 'MM',DATENAME(YEAR,'".$_GET['datestart']."')  AS 'YYYY'";
$query_seDate = sqlsrv_query($conn, $sql_seDate, $params_seDate);
$result_seDate = sqlsrv_fetch_array($query_seDate, SQLSRV_FETCH_ASSOC);
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
        
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <th colspan="16"> <label style="text-align: center"><font style="font-size: 32"><b>Time Diagram receiving at TTAST G/W To TKB</b></font></label></th>
                </tr>
                <tr>
                    <th colspan="16"> <label style="text-align: center"><font style="font-size: 28"><b>รายงานประจำเดือน <?=$result_seDate['MM']."' ".$result_seDate['YYYY']?></b></font></label></th>
                </tr>
                <tr>

                    <th> <label style="width: 50px;text-align: center">No.</label></th>
                    <th> <label style="width: 200px;text-align: center">DATE.</label></th>
                    <th> <label style="width: 200px;text-align: center">TRUCK.</label></th>
                    <th> <label style="width: 200px;text-align: left">TRIP.</label></th>
                    <th> <label style="width: 200px;text-align: left">TRUCK RIG.</label></th>
                    <th> <label style="width: 200px;text-align: center">DRIVER.</label></th>
                    <th> <label style="width: 200px;text-align: center">MOBILE/PHONE.</label></th>
                    <th> <label style="width: 200px;text-align: center">TT_IN.</label></th>
                    <th> <label style="width: 200px;text-align: center">TT_Wait.</label></th>
                    <th> <label style="width: 200px;text-align: center">TT_OUT.</label></th>
                    <th> <label style="width: 200px;text-align: center">TKB_IN.</label></th>
                    <th> <label style="width: 200px;text-align: center">TKB_Wait.</label></th>
                    <th> <label style="width: 200px;text-align: center">TKB_OUT.</label></th>
                    <th> <label style="width: 200px;text-align: center">PACK.</label></th>
                    <th> <label style="width: 200px;text-align: center">WEIGHT(kg.).</label></th>
                    <th> <label style="width: 200px;text-align: center">REMARK.</label></th>


                </tr>
                <tr style="color: red">

                   								

                    <th> <label style="width: 50px;text-align: center">ลำดับ.</label></th>
                    <th> <label style="width: 200px;text-align: center">ว/ด/ป.</label></th>
                    <th> <label style="width: 200px;text-align: center">ประเภทรถ.</label></th>
                    <th> <label style="width: 200px;text-align: left">เที่ยวที่.</label></th>
                    <th> <label style="width: 200px;text-align: left">ทะเบียนรถ.</label></th>
                    <th> <label style="width: 200px;text-align: center">ชื่อ พขร.</label></th>
                    <th> <label style="width: 200px;text-align: center">เบอร์โทร.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาเข้า TT.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาขึ้นงาน.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาออก TT.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาเข้า TKB.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาลงงาน.</label></th>
                    <th> <label style="width: 200px;text-align: center">เวลาออก TKB.</label></th>
                    <th> <label style="width: 200px;text-align: center">จำนวน/แพ๊ค.</label></th>
                    <th> <label style="width: 200px;text-align: center">น้ำหนักรวม.</label></th>
                    <th> <label style="width: 200px;text-align: center"></label></th>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $sumprice = "";
                $condBillings1 = " AND CONVERT(DATE,b.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) ";
                $condBillings2 = " AND b.COMPANYCODE = '" . $_GET['companycode'] . "' AND b.CUSTOMERCODE = '" . $_GET['customercode'] . "' ";
                $condBillings3 = " ";

                $sql_seBilling = "{call megVehicletransportdocumentdriver_v2(?,?,?,?)}";
                $params_seBilling = array(
                    array('select_vehicletransportdocumentdriver', SQLSRV_PARAM_IN),
                    array($condBillings1, SQLSRV_PARAM_IN),
                    array($condBillings2, SQLSRV_PARAM_IN),
                    array($condBillings3, SQLSRV_PARAM_IN)
                );



                $query_seBilling = sqlsrv_query($conn, $sql_seBilling, $params_seBilling);
                while ($result_seBilling = sqlsrv_fetch_array($query_seBilling, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td style="text-align: center"><?= $i ?></td>
                        <td style="text-align: center"><?= $result_seBilling['DATE_VLIN'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['VEHICLETYPE'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['TRIPAMOUNT'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['THAINAME'] ?></td>
                        <td style="text-align: left"><?= $result_seBilling['EMPLOYEENAME1'] ?></td>
                        <td style="text-align: left"><?= $result_seBilling['CurrentTel'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['TIMEVLIN'] ?></td>
                        <td style="text-align: center">-</td>
                        <td style="text-align: center"><?= $result_seBilling['TIMEVLOUT'] ?></td>
                        <td style="text-align: center"><?= $result_seBilling['TIMEDEALERIN'] ?></td>
                        <td style="text-align: center">-</td>
                        <td style="text-align: center">-</td>
                        <td style="text-align: center"><?= $result_seBilling['ROUNDAMOUNT'] ?></td>
                        <td style="text-align: left"><?= $result_seBilling['WEIGHTIN'] ?></td>
                        <td style="text-align: center">-</td>
                        
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </body>
</html>