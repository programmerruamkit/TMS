<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

$condition1 = " AND a.EMPLOYEEID =" . $_GET['employeeid'];
$sql_seEmployee = "{call megStopwork_v2(?,?)}";
$params_seEmployee = array(
    array('select_employeeehr2', SQLSRV_PARAM_IN),
    array($condition1, SQLSRV_PARAM_IN)
);
$query_seEmployee = sqlsrv_query($conn, $sql_seEmployee, $params_seEmployee);
$result_seEmployee = sqlsrv_fetch_array($query_seEmployee, SQLSRV_FETCH_ASSOC);


if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานการแจ้งหยุดรถของ" . $result_seEmployee['NAME'] . "ทั้งหมด.xls";
} else {
    $strExcelFileName = "รายงานการแจ้งหยุดรถของ" . $result_seEmployee['NAME'] . "ตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}
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
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ-สกุล(พขร.)</th>
                    <th>กระบวนการหยุด</th>
                    <th>เหตุผล</th>
                    <th>ประเภทรถ</th>
                    <th>สถานะรถ</th>
                    <th>ทะเบียนรถ</th>
                    <th>เบอร์รถ/ชื่อรถ</th>
                    <th>จุดจอด</th>
                    <th>เวลาที่เริ่มหยุด</th>
                    <th>เวลาที่หยุดเสร็จ</th>
                    <th>เวลา Tenko</th>
                    <th>วันที่</th>
                    <th>งานที่รับเที่ยวที่ 1</th>
                    <th>เวลาที่รับเที่ยวที่ 1</th>
                    <th>งานที่รับเที่ยวที่ 2</th>
                    <th>เวลาที่รับเที่ยวที่ 2</th>
                    <th>เลขใบส่งสินค้า</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $condition2 = "";
                $condition3 = "";
                if ($_GET['employeeid'] != "") {
                    if ($_GET['datestart'] != "" || $_GET['dateend'] != "") {
                        $condition2 = " AND a.EMPLOYEEID = '" . $_GET['employeeid'] . "' AND ( a.DATEINPUT BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
                    }
                } else {
                    if ($_GET['datestart'] != "" || $_GET['dateend'] != "") {
                        $condition2 = " AND ( a.DATEINPUT BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
                    }
                    if ($_GET['comp'] != "") {
                        $COMP_IN = str_replace(",", "','", $_GET['comp']);
                        $condition3 = " AND a.COMPANYCODE IN ('" . $COMP_IN . "')";
                    } else {
                        $condition3 = " AND a.COMPANYCODE IN ('RATC','RCC','RIT','RKL','RKP','RKR','RKS','RTC','RTD')";
                    }
                }
                $condition1 = $condition2 . $condition3;

                $sql_seStopwork = "{call megStopwork_v2(?,?)}";
                $params_seStopwork = array(
                    array('select_stopwork', SQLSRV_PARAM_IN),
                    array($condition1, SQLSRV_PARAM_IN)
                );


                $query_seStopwork = sqlsrv_query($conn, $sql_seStopwork, $params_seStopwork);
                while ($result_seStopwork = sqlsrv_fetch_array($query_seStopwork, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr class="odd gradeX">
                        <td><?= $result_seStopwork['EMPLOYEEID'] ?></td>
                        <td><?= $result_seStopwork['EMPLOYEENAME'] ?></td>
                        <td><?= $result_seStopwork['STOPPROCESS'] ?></td>
                        <td><?= $result_seStopwork['REASON'] ?></td>
                        <td><?= $result_seStopwork['VEHICLETYPEDESC'] ?></td>
                        <td><?= $result_seStopwork['CARSTATUS'] ?></td>
                        <td><?= $result_seStopwork['VEHICLEREGISNUMBER'] ?></td>
                        <td><?= $result_seStopwork['THAINAME'] ?></td>
                        <td><?= $result_seStopwork['PARKINGN'] ?></td>
                        <td><?= $result_seStopwork['STARTTIME'] ?></td>
                        <td><?= $result_seStopwork['STOPTIME'] ?></td>
                        <td><?= $result_seStopwork['TENKOTIME'] ?></td>
                        <td><?= $result_seStopwork['DATEINPUT'] ?></td>
                        <td><?= $result_seStopwork['JOBINPUT'] ?></td>
                        <td><?= $result_seStopwork['TIMEINPUT'] ?></td>
                        <td><?= $result_seStopwork['JOBINPUT2'] ?></td>
                        <td><?= $result_seStopwork['TIMEINPUT2'] ?></td>
                        <td><?= $result_seStopwork['PRODUCTNUMBER'] ?></td>

                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
    </body>
</html>