<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานเท็งโก๊ะ.xls";
} else {
    $strExcelFileName = "รายงานเท็งโก๊ะตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
                    <th>No</th>
                    <th>ชื่อผู้ขับขี่</th>
                    <th>ปัญหา</th>
                    <th>เท็งโก๊ะ</th>
                    <th>การแก้ไข</th>
                    <th>ผู้รับผิดชอบ</th>
                    <th>วันที่สิ้นสุด</th>
                    <th>สถานะ</th>
                    <th>หมายเหตุ</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $condition2 = "";
                $condition3 = "";
                if ($_GET['employeeid'] != "") {
                     if ($_GET['datestart'] != "" || $_GET['dateend'] != "") {
                        $condition2 = " AND a.EMPLOYEEID = '".$_GET['employeeid']."' AND ( a.DATEINPUT BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103))";
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

                $sql_seTenko = "{call megTenko_v2(?,?)}";
                $params_seTenko = array(
                    array('select_tenko', SQLSRV_PARAM_IN),
                    array($condition1, SQLSRV_PARAM_IN)
                );

                $i = 1;
                $query_seTenko = sqlsrv_query($conn, $sql_seTenko, $params_seTenko);
                while ($result_seTenko = sqlsrv_fetch_array($query_seTenko, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr class="odd gradeX">
                        <td><?= $i ?></td>
                        <td><?= $result_seTenko['EMPLOYEENAME'] ?></td>
                        <td><?= $result_seTenko['ISSUE'] ?></td>
                        <td><?= $result_seTenko['TENKO'] ?></td>
                        <td><?= $result_seTenko['REFORMATION'] ?></td>
                        <td><?= $result_seTenko['RESPONSIBLEPERSON'] ?></td>
                        <td><?= $result_seTenko['FINISHDATE'] ?></td>
                        <td><?= $result_seTenko['STATUS'] ?></td>
                        <td><?= $result_seTenko['REMARK'] ?></td>
                    </tr>
    <?php
    $i++;
}
?>
            </tbody>
        </table>
    </body>
</html>