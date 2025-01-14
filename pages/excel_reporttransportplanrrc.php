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
                    <th><label style="width: 200px">JOBDATE</label></th>
                    <th><label style="width: 200px">DRIVER(1)</label></th>
                    <!-- <th><label style="width: 200px">D/N</label></th>
                    <th><label style="width: 200px">PRODUCT TYPE</label></th> -->
                    <th><label style="width: 200px">BOOKNO</label></th>
                    <th><label style="width: 200px">DO</label></th>


                    <th><label style="width: 200px">FROM</label></th>
                    <th><label style="width: 200px">TO</label></th>
                    <th><label style="width: 200px">TRUCKTYPE</label></th>
                    <th><label style="width: 200px">VEHICLENO</label></th>
                    <th><label style="width: 200px">PACK</label></th>


                    <!-- <th><label style="width: 200px">ค่าเที่ยว (Driver1)</label></th> -->
                    <!-- <th><label style="width: 200px">น้ำหนัก 1</label></th> -->
                    <th><label style="width: 200px">น้ำหนัก 2</label></th>
                    <!-- <th><label style="width: 200px">TOTAL (NEW)</label></th> -->
                    <th><label style="width: 200px">ราคา</label></th>
                    <th><label style="width: 200px">เลขไมล์ต้น</label></th>
                    <th><label style="width: 200px">เลขไมล์ปลาย</label></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                //  $condiReporttransฆport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)";
                //  $condiReporttransport2 = " AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = '".$_GET['customercode']."'";
                // $condiReporttransport3 = "";
                // $sql_seReporttransport = "{call megVehicletransportplan_v2(?,?,?,?)}";
                // $params_seReporttransport = array(
                //     array('select_reportvehicletransportplangateway', SQLSRV_PARAM_IN),
                //     array($condiReporttransport1, SQLSRV_PARAM_IN),
                //     array($condiReporttransport2, SQLSRV_PARAM_IN),
                //     array($condiReporttransport3, SQLSRV_PARAM_IN)
                // );

                $sql_seReporttransport = "SELECT DISTINCT ROW_NUMBER() OVER (PARTITION BY a.EMPLOYEENAME1 ORDER BY b.VEHICLETRANSPORTPLANID) AS 'ROWNUM'
                    ,a.EMPLOYEENAME1 AS 'DRIVER(1)',a.EMPLOYEENAME2 AS 'DRIVER(2)'
                    ,a.JOBNO AS 'BOOKNO',CONVERT(VARCHAR(10), a.DATERK, 103) AS 'JOBDATE',
                    CONVERT(VARCHAR(5),CONVERT(TIME,a.DATERK)) AS 'JOBTIME','DAY' As 'DN',
                    a.JOBSTART AS 'FROM',b.JOBEND AS 'TO',a.VEHICLETYPE AS 'TRUCKTYPE',
                    CASE WHEN a.VEHICLEREGISNUMBER1 IS NULL THEN a.THAINAME ELSE a.VEHICLEREGISNUMBER1 END AS 'VEHICLENO',a.E1,b.WEIGHTOUT AS 'WEIGHTOUT1','' AS 'WEIGHTOUT2',
                    b.TRIPAMOUNT,b.DOCUMENTCODE,b.ACTUALPRICE ,a.ROUNDAMOUNT,
                    a.MATERIALTYPE AS 'PRODUCTTYPE','' AS 'INCOMEPERDRIVER',
                    a.VEHICLETRANSPORTPRICEID AS 'PRICEID',a.VEHICLETRANSPORTPRICEID AS 'PRICEID',a.ACTUALPRICE AS 'ACTUALPRICE'

                    FROM [dbo].[VEHICLETRANSPORTPLAN] a
                    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.VEHICLETRANSPORTPLANID = b.VEHICLETRANSPORTPLANID
                    WHERE 1 = 1
                    AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'".$_GET['dateend']."',103)
                    AND a.COMPANYCODE = '".$_GET['companycode']."' AND a.CUSTOMERCODE = '".$_GET['customercode']."'
                    AND b.JOBEND != 'TTAST'
                    AND b.DOCUMENTCODE IS NOT NULL
                    AND b.DOCUMENTCODE !=''
                    ORDER BY a.EMPLOYEENAME1 ASC";
                $params_seReporttransport = array();
                $query_seReporttransport = sqlsrv_query($conn, $sql_seReporttransport, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                ////////////NO///////////////////////
                if ($result_seReporttransport['ROWNUM'] > 1) {
                    $i--;
                    $NO = '';
                    $JOBDATE = '';
                    $DRIVER1 = '';
                    $BOOKNO = '';
                    $FROM = '';
                    $TO = '';
                    $TRUCKTYPE = '';
                    $VEHICLENO = '';
                }else {
                    $NO = $i;
                    $JOBDATE = $result_seReporttransport['JOBDATE'];
                    $DRIVER1 = $result_seReporttransport['DRIVER(1)'];
                    $BOOKNO = $result_seReporttransport['BOOKNO'];
                    $FROM = $result_seReporttransport['FROM'];
                    $TO = $result_seReporttransport['TO'];
                    $TRUCKTYPE = $result_seReporttransport['TRUCKTYPE'];
                    $VEHICLENO = $result_seReporttransport['VEHICLENO'];
                }

                    $sql_semileagestart = "SELECT TOP 1 MILEAGENUMBER  AS 'MILEAGESTART'
                        FROM MILEAGE  
                        WHERE JOBNO ='".$result_seReporttransport['BOOKNO']."'
                        AND MILEAGETYPE ='MILEAGESTART' 
                        ORDER BY CREATEDATE DESC";
                    $params_semileagestart = array();
                    $query_semileagestart = sqlsrv_query($conn, $sql_semileagestart, $params_semileagestart);
                    $result_semileagestart = sqlsrv_fetch_array($query_semileagestart, SQLSRV_FETCH_ASSOC);

                    $sql_semileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND'
                        FROM MILEAGE  
                        WHERE JOBNO ='".$result_seReporttransport['BOOKNO']."'
                        AND MILEAGETYPE ='MILEAGEEND' 
                        ORDER BY CREATEDATE DESC";
                    $params_semileageend = array();
                    $query_semileageend  = sqlsrv_query($conn, $sql_semileageend, $params_semileageend);
                    $result_semileageend = sqlsrv_fetch_array($query_semileageend, SQLSRV_FETCH_ASSOC);

                    ?>

                    <tr>

                        <td style="text-align: center"><?= $NO ?></td>
                        <td><?= $JOBDATE ?></td>
                        <td><?= $DRIVER1 ?></td>
                        <!-- <td><?= $result_seReporttransport['DN'] ?></td>
                        <td><?= $result_seReporttransport['PRODUCTTYPE'] ?></td> -->
                        <td><?= $BOOKNO ?></td>
                        <td><?= $result_seReporttransport['DOCUMENTCODE'] ?></td>
                        <td><?= $FROM ?></td>
                        <td><?= $TO ?></td>
                        <td><?= $TRUCKTYPE ?></td>
                        <td><?= $VEHICLENO ?></td>
                        <td><?= $result_seReporttransport['TRIPAMOUNT'] ?></td>
                        <!-- <td><?= $result_seReporttransport['E1'] ?></td> -->
                        <td><?= $result_seReporttransport['WEIGHTOUT1'] ?></td>
                        <!-- <td><?= $result_seReporttransport['WEIGHTOUT2'] ?></td> -->
                        <td><?= $result_seReporttransport['ACTUALPRICE'] ?></td>
                        <td><?= $result_semileagestart['MILEAGESTART'] ?></td>
                        <td><?= $result_semileageend['MILEAGEEND'] ?></td>



                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>
