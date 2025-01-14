<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
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
                    <th colspan="33">ตารางจัดส่งสินค้าประจำวันที่ <?= $_GET['datestart'] . ' - ' . $_GET['dateend'] ?></th>
                    <th colspan="2">Membory Card</th>



                </tr>
                <tr>
                    <th>ลำดับ</th>
                    <th>ช่องจ่ายสินค้า</th>
                    <th>Shipment</th>
                    <th>AD</th>
                    <th>รหัส</th>
                    <th>อำเภอ</th>

                    <th>จังหวัด</th>
                    <th>รถ</th>
                    <th>Ship to</th>
                    <th>ลำดับจัดส่ง</th>
                    <th>กำหนดรอบเวลา</th>

                    <th>สาขาส่ง</th>
                    <th>L4018DT + FD164E+FG</th>
                    <th>L5018DT + FD186F + FG186F </th>
                    <th>รวม</th>
                    <th>หมายเหตุ</th>
                    <th>ทะเบียนรถ</th>
                    <th>ชื่อ-สกุล</th>
                    <th>เบอร์โทร</th>
                    <th>ชื่อ-สกุล</th>
                    <th>เบอร์โทร</th>
                    <th>พขท.รายงานตัว</th>
                    <th>RKL</th>
                    <th>SKC</th>
                    <th>Loading Time (hr)</th>
                    <th>Out</th>
                    <th>Transport Time (hr)</th>
                    <th>Customer</th>
                    <th>UnloadingTime (hr)</th>
                    <th>Out</th>
                    <th>Transport Time (hr)</th>
                    <th>Date</th>
                    <th>พขท.ใช้งานเที่ยวถัดไป</th>
                    <th>รับ</th>
                    <th>ส่ง</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $condiReporttransport2 = "";
                $condiReporttransport3 = "";

                $sql_seReporttransport1 = "SELECT 
                b.BILLING2,
                b.LOCATION,
                b.ZONE,
                a.[THAINAME],
                a.[THAINAME2],
                convert(VARCHAR(5), a.DATERK, 14) AS 'TIMERK',
                a.VEHICLETYPE,
                a.[EMPLOYEENAME1],
                a.[EMPLOYEENAME2],
                d.CurrentTel AS 'TEL1',
                e.CurrentTel AS 'TEL2',
                convert(VARCHAR(5), a.DATEPRESENT, 14) AS 'TIMEPRESENT',
                convert(VARCHAR(5), a.DATEVLIN, 14) AS 'TIMEVLIN',
                convert(VARCHAR(5), a.DATEDEALERIN, 14) AS 'TIMEDEALERIN',
                CONVERT(VARCHAR(10), DATERK, 103) AS 'DATERK'
                FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                INNER JOIN VEHICLETRANSPORTPRICE b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER c ON a.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                LEFT JOIN [dbo].[EMPLOYEEEHR] d ON a.EMPLOYEECODE1 = d.PersonCode
                LEFT JOIN [dbo].[EMPLOYEEEHR] e ON a.EMPLOYEECODE1 = e.PersonCode
                WHERE 1=1 AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'SKB'" . $condiReporttransport1;



                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                    $sql_seConfrimskb = "SELECT JOBEND = STUFF((
                        SELECT ', ' + JOBEND
                        FROM dbo.CONFRIMSKB
                        WHERE VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "' 
                        FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, '') ";
                    $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                    $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                    $VAR_JOBEND = ($result_seReporttransport['CUSTOMERCODE'] == 'SKB') ? $result_seReporttransport['JOBSTART'] . '-' . $result_seConfrimskb['JOBEND'] : $result_seReporttransport['TO'];

                    $sql_seSumwight = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHTIN' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
                    WHERE [VEHICLETRANSPORTPLANID] = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'";
                    $query_seSumwight = sqlsrv_query($conn, $sql_seSumwight, $params_seSumwight);
                    $result_seSumwight = sqlsrv_fetch_array($query_seSumwight, SQLSRV_FETCH_ASSOC);
                    ?>

                    <tr>
                        <td>ADCR<?= $i ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['BILLING2'] ?></td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['LOCATION'] ?></td>
                        <td><?= $result_seReporttransport['ZONE'] ?></td>
                        <td><?= $result_seSumwight['VEHICLETYPE'] ?></td>
                        <td>-</td>
                        <td>1</td>

                        <td><?= $result_seReporttransport['TIMERK'] ?></td>
                        <td><?= $result_seReporttransport['LOCATION'] ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['THAINAME'] ?>/<?= $result_seReporttransport['THAINAME2'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME1'] ?></td>
                        <td><?= $result_seReporttransport['TEL1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME2'] ?></td>
                        <td><?= $result_seReporttransport['TEL2'] ?></td>
                        <td><?= $result_seReporttransport['TIMEPRESENT'] ?></td>
                        <td><?= $result_seReporttransport['TIMEVLIN'] ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['TIMEDEALERIN'] ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['DATERK'] ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
        <br>
        <table border="1">
            <thead>
                <tr>
                    <th colspan="11">ออกจาก ADC</th>
                 

                </tr>
                <tr>
                    <th>No</th>
                    <th>Zone</th>
                    <th>Code</th>
                    <th>AD</th>
                    <th>To</th>
                    <th>District</th>
                    <th>Province</th>
                    <th>สาขาหลัก</th>
                    <th>Branch</th>
                    <th>One way</th>
                    <th>All Distance</th>



                </tr>
            </thead>
            <tbody>
                <?php
                $i_1 = 1;
                $condiReporttransport1_1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $condiReporttransport2_1 = "";
                $condiReporttransport3_1 = "";

                $sql_seReporttransport1_1 = "SELECT 
                a.[JOBSTART],
                b.BILLING2,
                b.LOCATION,
                b.ZONE
                FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                INNER JOIN VEHICLETRANSPORTPRICE b ON a.VEHICLETRANSPORTPRICEID = b.VEHICLETRANSPORTPRICEID
                INNER JOIN VEHICLETRANSPORTDOCUMENTDIRVER c ON a.VEHICLETRANSPORTPLANID = c.VEHICLETRANSPORTPLANID
                LEFT JOIN [dbo].[EMPLOYEEEHR] d ON a.EMPLOYEECODE1 = d.PersonCode
                LEFT JOIN [dbo].[EMPLOYEEEHR] e ON a.EMPLOYEECODE1 = e.PersonCode
                WHERE 1=1 AND a.COMPANYCODE = 'RKL' AND a.CUSTOMERCODE = 'SKB'" . $condiReporttransport1;



                $query_seReporttransport_1 = sqlsrv_query($conn, $sql_seReporttransport1_1, $params_seReporttransport_1);
                while ($result_seReporttransport_1 = sqlsrv_fetch_array($query_seReporttransport_1, SQLSRV_FETCH_ASSOC)) {
                    $sql_seConfrimskb = "SELECT JOBEND = STUFF((
                        SELECT ', ' + JOBEND
                        FROM dbo.CONFRIMSKB
                        WHERE VEHICLETRANSPORTPLANID = '" . $result_seReporttransport_1['VEHICLETRANSPORTPLANID'] . "' 
                        FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, '') ";
                    $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                    $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                    $VAR_JOBEND = ($result_seReporttransport_1['CUSTOMERCODE'] == 'SKB') ? $result_seReporttransport_1['JOBSTART'] . '-' . $result_seConfrimskb['JOBEND'] : $result_seReporttransport['TO'];

                    $sql_seSumwight = "SELECT SUM(CONVERT(INT,WEIGHTIN)) AS 'WEIGHTIN' FROM [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER]
                    WHERE [VEHICLETRANSPORTPLANID] = '" . $result_seReporttransport_1['VEHICLETRANSPORTPLANID'] . "'";
                    $query_seSumwight = sqlsrv_query($conn, $sql_seSumwight, $params_seSumwight);
                    $result_seSumwight = sqlsrv_fetch_array($query_seSumwight, SQLSRV_FETCH_ASSOC);
                    ?>

                    <tr>
                        <td><?= $i_1 ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport_1['JOBSTART'] ?></td>
                        <td><?= $result_seReporttransport_1['BILLING2'] ?></td>
                        <td><?= $result_seReporttransport_1['LOCATION'] ?></td>
                        <td><?= $result_seReporttransport_1['ZONE'] ?></td>
                        <td>สาขาหลัก</td>
                        <td><?= $result_seReporttransport_1['LOCATION'] ?></td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <?php
                    $i_1++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>