<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(E_ERROR | E_PARSE);
$conn = connect("RTMS");

$strExcelFileName = "รายงานประวัติการซ่อมบำรุง.xls";


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
        <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
            <thead>
                <tr>
                    <td style="text-align:center;width: 5%;">ลำดับ</td>
                    <td style="text-align:center;width: 5%;">บริษัท</td>
                    <td style="text-align:center;width: 10%;">วันที่</td>
                    <td style="text-align:center;width: 10%;">ทะเบียนรถ</td>
                    <td style="text-align:center;width: 10%;">ช่างซ่อม</td>
                    <td style="text-align:center;width: 10%;">เลข JOB</td>
                    <td style="text-align:center;width: 10%;">ชื่องานซ่อม</td>
                    <td style="text-align:center;width: 20%;">รายละเอียดงานซ่อม</td>
                    <td style="text-align:center;width: 5%;">ปริมาณ</td>
                    <td style="text-align:center;width: 5%;">ราคาต่อหน่วย</td>
                    <td style="text-align:center;width: 5%;">ราคาขาย</td>
                    <td style="text-align:center;width: 5%;">รวมเป็นเงิน</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
//DESC1 =รายละเอียด ,QTYBOD=ปริมาณ,NETPRC=ราคาต่อหน่วย,TOTPRC=รวมเป็นเงิน
                $REGNO = ($_GET['vehiclenumber'] == "") ? "" : " AND REGNO = '" . $_GET['vehiclenumber'] . "'";
                $NAME = ($_GET['name'] == "") ? "" : " AND MECHANIC = '" . $_GET['name'] . "'";
                $DESC1 = ($_GET['desc1'] == "") ? "" : " AND TYPNAME LIKE '%" . $_GET['desc1'] . "%'";
                $sql_seRepairData = "SELECT [RKTCID], [NICKNM], [CUSCOD], CONVERT(NVARCHAR(10),CONVERT(DATE,[OPENDATE],103),103) AS 'OPENDATE', [CLOSEDATE], [TAXINVOICEDATE], [REGNO], [CHASSIS], [MILEAGE], 
                    [JOBNO], [TYPNAME], [SPAREPARTSDETAIL], [NET], [COST], [SELLING], [SPAREPARTSSELLER], [SUMMARY], [WAGES], [MECHANIC], 
                    [WORKINGHOURS], [COLLECTIONHOURS], [AREA], [REMARK], [ACTIVESTATUS]
                    FROM RKTC WHERE 1=1
                    AND CONVERT(DATE,OPENDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)" . $REGNO . $NAME . $DESC1;
                $params_seRepairData = array();
                $query_seRepairData = sqlsrv_query($conn, $sql_seRepairData, $params_seRepairData);
                while ($result_seRepairData = sqlsrv_fetch_array($query_seRepairData, SQLSRV_FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td style="text-align:center;"><?= $i ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['NICKNM'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['OPENDATE'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['REGNO'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['MECHANIC'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['JOBNO'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['TYPNAME'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['SPAREPARTSDETAIL'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['NET'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['COST'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['SELLING'] ?></td>
                        <td style="text-align:center;"><?= $result_seRepairData['SUMMARY'] ?></td>


                    </tr>
    <?php
    $i++;
}
?>

            </tbody>
        </table>
    </body>
</html>
