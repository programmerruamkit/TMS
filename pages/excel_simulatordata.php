<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['yearstart'] == "" || $_GET['yearend'] == "") {
    $strExcelFileName = "รายงาน Simulator.xls";
} else {
    $strExcelFileName = "รายงาน Simulator(" .$_GET['employeecode']. ') ปี ' . $_GET['yearstart'] . ' ถึง ' . $_GET['yearend'] . ".xls";
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
                <tr style="background-color: #999">									
                    <th>ลำดับ</th>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อพนักงาน</th>
                    <th>อายุพนักงาน</th>
                    <th>วันที่ TLEP ครั้งแรก</th>
                    <th>ผ่าน TLEP ล่าสุด</th>
                    <th>T-LEP Years</th>
                    <th>จุดอ่อนข้อที่ 1 </th>
                    <th>จุดอ่อนข้อที่ 2 </th>
                    <th>จุดอ่อนข้อที่ 3 </th>  
                    <th>สวมแว่นสายตา</th>  
                </tr>
            </thead>
            <tbody>
                <?php
                $i= 1;
                
                $sql_seSimulatorData = "SELECT a.SIMUID,a.DRIVERCODE,a.DRIVERNAME,a.YEARSSIMU,a.TLEP_FIRSTDATE,a.TLEP_FOLLOWUP,
                a.SIMUDATA1,a.SIMUDATA2,a.SIMUDATA3,a.TLEP_WEARGLASSES,b.BirthDate103,b.[yearb],b.monthb,b.dayb,
                CAST(DATEDIFF(yy, TLEP_FOLLOWUP, GETDATE()) AS varchar(4)) +' Year ' AS 'TLEP_YEAR',
                CAST(DATEDIFF(mm, DATEADD(yy, DATEDIFF(yy, TLEP_FOLLOWUP, GETDATE()), TLEP_FOLLOWUP), GETDATE()) AS varchar(2)) +' Month ' AS 'TLEP_MONTH'
                FROM SIMULATORHISTORY a
                INNER JOIN EMPLOYEEEHR2 b ON b.PersonCode = a.DRIVERCODE
                WHERE a.DRIVERCODE = '".$_GET['employeecode']."'
                AND a.YEARSSIMU BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
                ORDER BY a.YEARSSIMU ASC";
                $params_seSimulatorData = array();
                $query_seSimulatorData = sqlsrv_query($conn, $sql_seSimulatorData, $params_seSimulatorData);
                while ($result_seSimulatorData = sqlsrv_fetch_array($query_seSimulatorData, SQLSRV_FETCH_ASSOC)) {

                // $sql_seDriverAge = "SELECT BirthDate103,[yearb],monthb,dayb FROM EMPLOYEEEHR2
                //     WHERE PersonCode ='".$_GET['employecode']."'";
                // $params_seDriverAge = array();
                // $query_seDriverAge  = sqlsrv_query($conn, $sql_seDriverAge , $params_seDriverAge);
                // $result_seDriverAge  = sqlsrv_fetch_array($query_seDriverAge , SQLSRV_FETCH_ASSOC);

                // $sql_seTlepY = "SELECT DATEDIFF(year,'".$result_seSimulatorData['TLEP_PASS']."', GETDATE()) AS 'YEARDIFF'
                //     FROM  [dbo].[SIMULATORHISTORY] 
                //     WHERE DRIVERCODE = '".$_GET['employecode']."'
                //     AND YEARSSIMU =  YEAR(GETDATE())";
                // $params_seTlepY = array();
                // $query_seTlepY  = sqlsrv_query($conn, $sql_seTlepY , $params_seTlepY);
                // $result_seTlepY  = sqlsrv_fetch_array($query_seTlepY , SQLSRV_FETCH_ASSOC);

                // $sql_seTlepM = "SELECT DATEDIFF(month,'".$result_seSimulatorData['TLEP_PASS']."', GETDATE()) AS 'MONTHDIFF'
                //     FROM  [dbo].[SIMULATORHISTORY] 
                //     WHERE DRIVERCODE = '".$_GET['employecode']."'
                //     AND YEARSSIMU =  YEAR(GETDATE())";
                // $params_seTlepM = array();
                // $query_seTlepM  = sqlsrv_query($conn, $sql_seTlepM , $params_seTlepM);
                // $result_seTlepM  = sqlsrv_fetch_array($query_seTlepM , SQLSRV_FETCH_ASSOC);
                                                                

                ?>

                    <tr>
                        <td style="text-align: center"><?= $i ?></td>
                        <td>&nbsp;<?= $result_seSimulatorData['DRIVERCODE'] ?></td>
                        <td><?= $result_seSimulatorData['DRIVERNAME'] ?></td>
                        <td><?= $result_seSimulatorData['yearb'] ?> Y <?= $result_seSimulatorData['monthb']?> M</td>
                        <td><?= $result_seSimulatorData['TLEP_FIRSTDATE'] ?></td>
                        <td><?= $result_seSimulatorData['TLEP_FOLLOWUP'] ?></td>
                        <td><?= $result_seSimulatorData['TLEP_YEAR'] ?>&nbsp;and&nbsp;<?= $result_seSimulatorData['TLEP_MONTH'] ?></td>
                        <td><?= $result_seSimulatorData['SIMUDATA1'] ?></td>
                        <td><?= $result_seSimulatorData['SIMUDATA2'] ?></td>
                        <td><?= $result_seSimulatorData['SIMUDATA3'] ?></td>
                        <td><?= $result_seSimulatorData['TLEP_WEARGLASSES']  == '1' ? 'สวมแว่น' : 'ไม่สวมแว่น' ?></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>

            </tbody>
        </table>
    </body>
</html>