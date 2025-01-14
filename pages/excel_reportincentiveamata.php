<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300);
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
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
                    <th><label style="width: 200px">JOBDATE</label></th>
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
                    <th><label style="width: 200px">FUEL AVG</label></th>
                    <th><label style="width: 200px">ROUNDAMOUNT</label></th>




                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                // $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                if($_GET['companycode'] == 'ALL' && $_GET['customercode'] == 'ALL'){ 
                // echo 'ALL';
                $sql_seReporttransport1 = "SELECT DISTINCT a.CUSTOMERCODE,a.COMPANYCODE
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14) AS 'DATETIME'
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103)  AS 'JOBDATE'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 103) AS 'DD'
                    ,CONVERT(VARCHAR(4), a.DATEWORKING, 102) AS 'YYYY'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 101) AS 'MM'
                    ,a.JOBNO,a.THAINAME AS 'TRUCKNO',a.THAINAME2 AS 'TRAILERNO',a.JOBSTART+'-'+a.JOBEND AS 'ROUTE',a.JOBSTART,
                    a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,a.EMPLOYEECODE1
                    ,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,a.E1,a.E2,a.C3
                    FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                    WHERE 1=1 AND a.COMPANYCODE !='RRC' AND a.COMPANYCODE !='RCC' AND a.COMPANYCODE !='RATC' AND b.DOCUMENTCODE IS NOT NULL
                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    AND b.DOCUMENTCODE != ''
                    GROUP BY a.CUSTOMERCODE,a.COMPANYCODE,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14),
                    CONVERT(VARCHAR(10), a.DATEWORKING, 103),CONVERT(VARCHAR(4), a.DATEWORKING, 102),CONVERT(VARCHAR(2), a.DATEWORKING, 101),
                    CONVERT(VARCHAR(2), a.DATEWORKING, 103),a.JOBNO,a.THAINAME,a.THAINAME2,a.JOBSTART,a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,
                    a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.COMPENSATION,a.E1,a.E2,a.C3
                    ORDER BY a.COMPANYCODE,a.CUSTOMERCODE,CONVERT(VARCHAR(10), a.DATEWORKING, 103) ASC";
                }else if ($_GET['customercode'] == 'ALL'){
                    // echo 'SELECT CUSTOMER';
                $sql_seReporttransport1 = "SELECT DISTINCT a.CUSTOMERCODE,a.COMPANYCODE
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14) AS 'DATETIME'
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103)  AS 'JOBDATE'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 103) AS 'DD'
                    ,CONVERT(VARCHAR(4), a.DATEWORKING, 102) AS 'YYYY'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 101) AS 'MM'
                    ,a.JOBNO,a.THAINAME AS 'TRUCKNO',a.THAINAME2 AS 'TRAILERNO',a.JOBSTART+'-'+a.JOBEND AS 'ROUTE',a.JOBSTART,
                    a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,a.EMPLOYEECODE1
                    ,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,a.E1,a.E2,a.C3
                    FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                    WHERE 1=1 AND a.COMPANYCODE !='RRC' AND a.COMPANYCODE !='RCC' AND a.COMPANYCODE !='RATC' AND b.DOCUMENTCODE IS NOT NULL
                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    AND a.COMPANYCODE='".$_GET['companycode']."'
                    AND b.DOCUMENTCODE != ''
                    GROUP BY a.CUSTOMERCODE,a.COMPANYCODE,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14),
                    CONVERT(VARCHAR(10), a.DATEWORKING, 103),CONVERT(VARCHAR(4), a.DATEWORKING, 102),CONVERT(VARCHAR(2), a.DATEWORKING, 101),
                    CONVERT(VARCHAR(2), a.DATEWORKING, 103),a.JOBNO,a.THAINAME,a.THAINAME2,a.JOBSTART,a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,
                    a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.COMPENSATION,a.E1,a.E2,a.C3
                    ORDER BY CONVERT(VARCHAR(10), a.DATEWORKING, 103) ASC";
                }else{
                    // echo 'SELECT CUSTOMER';
                $sql_seReporttransport1 = "SELECT DISTINCT a.CUSTOMERCODE,a.COMPANYCODE
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14) AS 'DATETIME'
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103)  AS 'JOBDATE'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 103) AS 'DD'
                    ,CONVERT(VARCHAR(4), a.DATEWORKING, 102) AS 'YYYY'
                    ,CONVERT(VARCHAR(2), a.DATEWORKING, 101) AS 'MM'
                    ,a.JOBNO,a.THAINAME AS 'TRUCKNO',a.THAINAME2 AS 'TRAILERNO',a.JOBSTART+'-'+a.JOBEND AS 'ROUTE',a.JOBSTART,
                    a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,a.EMPLOYEECODE1
                    ,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,a.E1,a.E2,a.C4,a.C5,a.C3
                    FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                    WHERE 1=1 AND a.COMPANYCODE !='RRC' AND a.COMPANYCODE !='RCC' AND a.COMPANYCODE !='RATC' AND b.DOCUMENTCODE IS NOT NULL
                    AND CONVERT(DATE,a.DATEWORKING) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
                    AND b.DOCUMENTCODE != ''
                    GROUP BY a.CUSTOMERCODE,a.COMPANYCODE,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14),
                    CONVERT(VARCHAR(10), a.DATEWORKING, 103),CONVERT(VARCHAR(4), a.DATEWORKING, 102),CONVERT(VARCHAR(2), a.DATEWORKING, 101),
                    CONVERT(VARCHAR(2), a.DATEWORKING, 103),a.JOBNO,a.THAINAME,a.THAINAME2,a.JOBSTART,a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,
                    a.EMPLOYEECODE1,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.COMPENSATION,a.E1,a.E2,a.C4,a.C5,a.C3
                    ORDER BY CONVERT(VARCHAR(10), a.DATEWORKING, 103) ASC";
                }
                

                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport1, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                    // $sql_seConfrimskb = "SELECT JOBEND = STUFF((
                    //     SELECT ', ' + JOBEND
                    //     FROM dbo.CONFRIMSKB
                    //     WHERE VEHICLETRANSPORTPLANID = '" . $result_seReporttransport['VEHICLETRANSPORTPLANID'] . "'
                    //     FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, '') ";
                    // $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                    // $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                    // $VAR_JOBEND = ($result_seReporttransport['CUSTOMERCODE'] == 'SKB') ? $result_seReporttransport['JOBSTART'].'-'.$result_seConfrimskb['JOBEND'] : $result_seReporttransport['ROUTE'];

                    // $sql_seData= "SELECT  a.THAINAME2 AS 'TRAILERNO',a.JOBSTART+'-'+a.JOBEND AS 'ROUTE',a.JOBSTART,
                    // a.JOBEND,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE,a.EMPLOYEECODE1
                    // ,a.EMPLOYEENAME1,a.EMPLOYEECODE2,a.EMPLOYEENAME2,b.COMPENSATION,a.E1,a.E2
                    // FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a
                    // INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                    // WHERE 1=1 AND a.COMPANYCODE !='RRC' AND a.COMPANYCODE !='RCC' AND a.COMPANYCODE !='RATC' AND b.DOCUMENTCODE IS NOT NULL
                    // AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    // AND a.COMPANYCODE='".$_GET['companycode']."' AND a.CUSTOMERCODE='".$_GET['customercode']."'
                    // AND b.DOCUMENTCODE != '' AND a.JOBNO='".$result_seReporttransport['JOBNO']."' ";
                    // $query_seData = sqlsrv_query($conn, $sql_seData, $params_seConfrimskb);
                    // $result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC);
                    if ($_GET['companycode'] == 'RKS' && $_GET['customercode'] == 'STM') {

                        $sql_seRoundamount = "SELECT SUM(CAST(SUBSTRING(ROUNDAMOUNT, 1, 2)AS INT)) AS 'CNT' 
                        FROM [dbo].[VEHICLETRANSPORTPLAN]
                        WHERE JOBNO ='" . $result_seReporttransport['JOBNO'] . "' ";
                        $query_seRoundamount = sqlsrv_query($conn, $sql_seRoundamount, $params_seRoundamount);
                        $result_seRoundamount = sqlsrv_fetch_array($query_seRoundamount, SQLSRV_FETCH_ASSOC);

                        $ROUNDAMOUNT = $result_seRoundamount['CNT'];
                    }else {
                        $ROUNDAMOUNT = '1';
                    }

                    $INCENTIVE =  ($result_seReporttransport['E1']+$result_seReporttransport['E2']+$result_seReporttransport['C4']+$result_seReporttransport['C5']);


                    ?>

                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $result_seReporttransport['CUSTOMERCODE'] ?></td>
                        <td><?= $result_seReporttransport['COMPANYCODE'] ?></td>
                        <td><?= $result_seReporttransport['MM'] ?>/<?=$result_seReporttransport['DD']?>/<?=$result_seReporttransport['YYYY']?></td>
                        <td><?= $result_seReporttransport['DD'] ?></td>
                        <td><?= $result_seReporttransport['YYYY'] ?></td>
                        <td><?= $result_seReporttransport['MM'] ?></td>
                        <td><?= $result_seReporttransport['JOBNO'] ?></td>
                        <td><?= $result_seReporttransport['TRUCKNO'] ?></td>
                        <td><?= $result_seReporttransport['TRAILERNO'] ?></td>
                        <td><?= $result_seReporttransport['ROUTE'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLETYPE'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE2'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME2'] ?></td>
                        <td><?= $result_seReporttransport['E1']+$result_seReporttransport['C4'] ?></td>
                        <td><?= $result_seReporttransport['E2']+$result_seReporttransport['C5'] ?></td>
                        <td><?= $INCENTIVE ?></td>
                        <td><?= $result_seReporttransport['C3'] ?></td>
                        <td style="text-align: center"><?= $ROUNDAMOUNT ?></td>

                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>
