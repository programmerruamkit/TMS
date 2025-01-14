<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['yearstart'] == "" || $_GET['yearend'] == "") {
    $strExcelFileName = "รายงานข้อมูลอุบัติเหตุ.xls";
} else {
    $strExcelFileName = "รายงานข้อมูลอุบัติเหตุ(" .$_GET['drivername']. ') ปี ' . $_GET['yearstart'] . ' ถึง ' . $_GET['yearend'] . ".xls";
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
                    <th>ชื่อพนักงาน</th>
                    <th>วันที่เวลาที่เกิดอุบัติเหตุ</th>
                    <th>สถานที่เกิดอุบัติเหตุ</th>
                    <th>ปัญหาของอุบัติเหตุ</th>
                    <th>MAN</th>
                    <th>METHOD</th>
                    <th>MECHINE</th>
                    <th>ENVIRONMENT</th>
                    <th>หมายเหตุ</th>
                    <th>ประเภทของอุบัติเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $iAccident = 1;
                
                $sql_seAccidentData = "SELECT DRIVERCODE,DRIVERNAME,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
                    CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',
                    CONVERT(VARCHAR(10), DATETIMEACCIDENT, 103) + ' '  + convert(VARCHAR(8), DATETIMEACCIDENT, 14) AS 'DATETIME',
                    DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
                    DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
                    FROM ACCIDENTHISTORY
                    WHERE DRIVERCODE = '".$_GET['drivercode']."'
                    AND YEARS BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
                    ORDER BY YEARS,DATETIMEACCIDENT ASC";
                $params_seAccidentData = array();
                $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);
                while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {
                
                    // $sql_seVeh = "SELECT B.VEHICLETYPEAMOUNT FROM [dbo].[VEHICLEINFO] A
                    //     LEFT JOIN dbo.VEHICLETYPEGETWAY B ON A.VEHICLETYPECODE = B.VEHICLETYPECODE
                    //     WHERE B.VEHICLETYPEDESC IN ('4L','8L','10W','22W','10WVAN','Full trailer','Semi trailer') 
                    //     AND A.VEHICLEREGISNUMBER = '".$result_seReporttransport['VEHICLEREGISNUMBER1']."'";
                    // $params_seVeh = array();
                    // $query_seVeh = sqlsrv_query($conn, $sql_seVeh, $params_seVeh);
                    // $result_seVeh = sqlsrv_fetch_array($query_seVeh, SQLSRV_FETCH_ASSOC);

                ?>

                    <tr>

                        <td style="text-align: center"><?= $iAccident ?></td>
                        <td><?= $result_seAccidentData['DRIVERNAME'] ?></td>
                        <td><?= $result_seAccidentData['DATETIME'] ?></td>
                        <td><?= $result_seAccidentData['LOCATIONACCIDENT'] ?></td>
                        <td><?= $result_seAccidentData['PROBLEMACCIDENT'] ?></td>
                        <td><?= $result_seAccidentData['DETAILMAN'] ?></td>
                        <td><?= $result_seAccidentData['DETAILMETHOD'] ?></td>
                        <td><?= $result_seAccidentData['DETAILMECHINE'] ?></td>
                        <td><?= $result_seAccidentData['DETAILENVIRONMENT'] ?></td>
                        <td><?= $result_seAccidentData['REMARK'] ?></td>
                        <td><?= $result_seAccidentData['TYPEACCIDENT'] ?></td>

                    </tr>
                    <?php
                    $iAccident++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>