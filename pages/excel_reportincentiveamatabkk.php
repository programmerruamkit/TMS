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
                    <th><label style="width: 50px">NO</label></th>
                    <th><label style="width: 200px">CUSTOMERCODE</label></th>
                    <th><label style="width: 200px">COMPANYCODE</label></th>
                    <th><label style="width: 200px">DATE</label></th>
                    <th><label style="width: 200px">YYYY</label></th>
                    <th><label style="width: 200px">MM</label></th>
                    <th><label style="width: 200px">JOBNO</label></th>
                    <th><label style="width: 200px">TRUCKNO</label></th>
                    <th><label style="width: 200px">TRAILERNO</label></th>
                    <th><label style="width: 200px">ROUTE</label></th>
                    <th><label style="width: 200px">TRUCKTYPE</label></th>
                    <th><label style="width: 200px">CODE DRIVER1</label></th>
                    <th><label style="width: 200px">DRIVER1</label></th>
                    <th><label style="width: 200px">CODE DRIVER2</label></th>
                    <th><label style="width: 200px">DRIVER2</label></th>
                    <th><label style="width: 200px">INC DRIVER1</label></th>
                    <th><label style="width: 200px">INC DRIVER2</label></th>
                    <th><label style="width: 200px">TOTAL</label></th>




                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $sql_seReporttransport1 = "SELECT a.CUSTOMERCODE,a.COMPANYCODE
                ,CONVERT(VARCHAR(10), a.DATERK, 103) + ' '  + convert(VARCHAR(8), a.DATERK, 14) AS 'DATETIME'
                ,CONVERT(VARCHAR(10), a.DATERK, 103)  AS 'JOBDATE'
                ,CONVERT(VARCHAR(4), a.DATEVLIN, 102) AS 'YYYY'
                ,CONVERT(VARCHAR(2), a.DATEVLOUT, 101) AS 'MM'
                ,a.JOBNO,a.THAINAME AS 'TRUCKNO',a.THAINAME2 AS 'TRAILERNO',a.JOBSTART+'-'+a.JOBEND AS 'ROUTE',a.JOBSTART,
                a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,a.EMPLOYEECODE1
                ,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.COMPENSATION,a.E1,a.E2
                FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                WHERE 1=1 AND a.COMPANYCODE !='RRC' AND a.COMPANYCODE !='RCC' AND a.COMPANYCODE !='RATC' AND b.DOCUMENTCODE IS NOT NULL
                AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                AND b.DOCUMENTCODE != '' ORDER BY a.COMPANYCODE,JOBDATE ASC";

                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                    $sql_seConfrimskb = "SELECT JOBEND = STUFF((
                        SELECT ', ' + JOBEND
                        FROM dbo.CONFRIMSKB
                        WHERE VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                        FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, '') ";
                    $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                    $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                    $VAR_JOBEND = ($result_seReporttransport['CUSTOMERCODE'] == 'SKB') ? $result_seReporttransport['JOBSTART'].'-'.$result_seConfrimskb['JOBEND'] : $result_seReporttransport['ROUTE'];
                    ?>

                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $result_seReporttransport['CUSTOMERCODE'] ?></td>
                        <td><?= $result_seReporttransport['COMPANYCODE'] ?></td>
                        <td><?= $result_seReporttransport['DATE'] ?></td>
                        <td><?= $result_seReporttransport['YYYY'] ?></td>
                        <td><?= $result_seReporttransport['MM'] ?></td>
                        <td><?= $result_seReporttransport['JOBNO'] ?></td>
                        <td><?= $result_seReporttransport['TRUCKNO'] ?></td>
                        <td><?= $result_seReporttransport['TRAILERNO'] ?></td>
                        <td><?= $VAR_JOBEND ?></td>
                        <td><?= $result_seReporttransport['VEHICLETYPE'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE2'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME2'] ?></td>
                        <td><?= $result_seReporttransport['E1'] ?></td>
                        <td><?= $result_seReporttransport['E2'] ?></td>
                        <td><?= ($result_seReporttransport['E1'])+($result_seReporttransport['E2']) ?></td>

                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>
