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
                                                    <th><label style="width: 200px">BOOKNO</label></th>
                                                    <th><label style="width: 200px">DO</label></th>
                                                    <th><label style="width: 200px">JOBDATE</label></th>
                                                    <th><label style="width: 200px">D/N</label></th>
                                                    <th><label style="width: 200px">PRODUCT TYPE</label></th>
                                                    <th><label style="width: 200px">FROM</label></th>
                                                    <th><label style="width: 200px">TO</label></th>
                                                    <th><label style="width: 200px">TRUCKTYPE</label></th>
                                                    <th><label style="width: 200px">VEHICLENO</label></th>
                                                    <th><label style="width: 200px">PACK</label></th>
                                                    <th><label style="width: 200px">UNIT PRICE JOB</label></th>
                                                    <th><label style="width: 200px">QTN_PRICE</label></th>
                                                    <th><label style="width: 200px">TOTAL(ORIGINAL)</label></th>
                                                    <th><label style="width: 200px">+ - PRICE</label></th>
                                                    <th><label style="width: 200px">UNIT PRICE (New)</label></th>
                                                    <th><label style="width: 200px">INCOMEPERDRIVER</label></th>
                                                    <th><label style="width: 200px">TOTAL(NEW)</label></th>
                                                    <th><label style="width: 200px">DRIVER(1)</label></th>
                                                    <th><label style="width: 200px">ค่าเที่ยว (Driver1)</label></th>
                                                    <th><label style="width: 200px">น้ำหนัก 1</label></th>
                                                    <th><label style="width: 200px">น้ำหนัก 2</label></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                 $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
                                                 $condiReporttransport2 = " AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = '".$_GET['customercode']."'";
                                                $condiReporttransport3 = "";
                                                $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                                                $params_seReporttransport = array(
                                                    array('select_reportvehicletransportplangateway', SQLSRV_PARAM_IN),
                                                    array($condiReporttransport1, SQLSRV_PARAM_IN),
                                                    array($condiReporttransport2, SQLSRV_PARAM_IN),
                                                    array($condiReporttransport3, SQLSRV_PARAM_IN)
                                                );
                                                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                                                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                                                    ?>

                                                    <tr>
                                                        
                                                        <td style="text-align: center"><?= $i ?></td>
                                                        <td><?= $result_seReporttransport['BOOKNO'] ?></td>
                                                        <td><?= $result_seReporttransport['DOCUMENTCODE'] ?></td>
                                                        <td><?= $result_seReporttransport['JOBDATE'] ?></td>
                                                        <td><?= $result_seReporttransport['DN'] ?></td>
                                                        <td><?= $result_seReporttransport['PRODUCTTYPE'] ?></td>
                                                        <td><?= $result_seReporttransport['FROM'] ?></td>
                                                        <td><?= $result_seReporttransport['TO'] ?></td>
                                                        <td><?= $result_seReporttransport['TRUCKTYPE'] ?></td>
                                                        <td><?= $result_seReporttransport['VEHICLENO'] ?></td>
                                                        <td><?= $result_seReporttransport['PACK'] ?></td>
                                                        <td><?= $result_seReporttransport['UNITPRICEJOB'] ?></td>
                                                        <td><?= $result_seReporttransport['QTNPRICE'] ?></td>
                                                        <td><?= $result_seReporttransport['TOTALORIGINAL'] ?></td>
                                                        <td><?= $result_seReporttransport['PRICENP'] ?></td>
                                                        <td><?= $result_seReporttransport['UNITPRICENEW'] ?></td>
                                                        <td><?= $result_seReporttransport['INCOMEPERDRIVER'] ?></td>
                                                        <td><?= $result_seReporttransport['TOTALNEW'] ?></td>
                                                        <td><?= $result_seReporttransport['DRIVER(1)'] ?></td>
                                                        <td><?= $result_seReporttransport['ค่าเที่ยว (Driver1)'] ?></td>
                                                        <td><?= $result_seReporttransport['WEIGHTOUT1'] ?></td>
                                                        <td><?= $result_seReporttransport['WEIGHTOUT2'] ?></td>
                                                       

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>




                                            </tbody>
        </table>
    </body>
</html>