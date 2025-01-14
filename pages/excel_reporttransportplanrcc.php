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
                <tr style="background-color: #999">									

                    <th>NO</th>
                    <th>BOOKNO</th>
                    <th>DO</th>
                    <th>JOBDATE</th>
                    <th>D/N</th>
                    <th>EXTRAROUTE</th>
                    <th>FROM</th>
                    <th>TO</th>
                    <th>TRUCKTYPE</th>
                    <th>VEHICLENO</th>
                    <th>UNITS</th>
                    <th>UNIT PRICE JOB</th>
                    <th>QTN_PRICE</th>
                    <th>TOTAL(ORIGINAL)</th>
                    <th>+ - PRICE</th>
                    <th>UNIT PRICE (New)</th>
                    <th>TOTAL(NEW)</th>
                    <th>Driver(1)</th>
                    <th>ค่าเที่ยว(Driver 1)</th>
                    <th>ค่าเที่ยวตีเปล่า(Driver 1)</th>
                    <th>Driver(2)</th>
                    <th>ค่าเที่ยว(Driver 2)</th>
                    <th>ค่าเที่ยวตีเปล่า(Driver 2)</th>
                    <th>เลขไมล์ต้น</th>  
                    <th>เลขไมล์ปลาย</th>
                    <th>สถานะแผนงาน</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $condiReporttransport1 = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) ";
                $condiReporttransport2 = " AND a.COMPANYCODE = '" . $_GET['companycode'] . "' AND a.CUSTOMERCODE = '" . $_GET['customercode'] . "' ORDER BY a.DATEVLIN,a.EMPLOYEENAME1 ASC ";
                $condiReporttransport3 = "";
                $sql_seReporttransport = "SELECT a.[VEHICLETRANSPORTPLANID]
                    ,a.[JOBNO]
                    ,b.[DOCUMENTCODE]
                    ,CONVERT(VARCHAR(10), a.DATEVLIN, 103) AS 'JOBDATE'
                    ,a.JOBSTART
                    ,a.JOBEND
                    ,a.VEHICLEREGISNUMBER1
                    ,b.[TRIPAMOUNT]
                    ,a.ACTUALPRICE
                    ,a.EMPLOYEENAME1
                    ,b.COMPENSATION1
                    ,b.COMPENSATIONEMPTY1
                    ,a.EMPLOYEENAME2
                    ,b.COMPENSATION2
                    ,b.COMPENSATIONEMPTY2
                    ,a.STATUSNUMBER
                    ,a.STATUS
                    ,CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKING, 14) AS 'DATEWORKING'
                    FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] a 
                    INNER JOIN [dbo].[VEHICLETRANSPORTDOCUMENTDIRVER] b ON a.[VEHICLETRANSPORTPLANID] = b.[VEHICLETRANSPORTPLANID]
                    WHERE 1=1 " . $condiReporttransport1 . $condiReporttransport2 . $condiReporttransport3;
                $query_seReporttransport = sqlsrv_query($conn,$sql_seReporttransport,$params_seReporttransport); 
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                
                    $sql_seVeh = "SELECT B.VEHICLETYPEAMOUNT FROM [dbo].[VEHICLEINFO] A
                        LEFT JOIN dbo.VEHICLETYPEGETWAY B ON A.VEHICLETYPECODE = B.VEHICLETYPECODE
                        WHERE B.VEHICLETYPEDESC IN ('4L','8L','10W','22W','10WVAN','Full trailer','Semi trailer') 
                        AND A.VEHICLEREGISNUMBER = '".$result_seReporttransport['VEHICLEREGISNUMBER1']."'";
                    $params_seVeh = array();
                    $query_seVeh = sqlsrv_query($conn, $sql_seVeh, $params_seVeh);
                    $result_seVeh = sqlsrv_fetch_array($query_seVeh, SQLSRV_FETCH_ASSOC);

                    $sql_semileagestart = "SELECT TOP 1 MILEAGENUMBER  AS 'MILEAGESTART'
                    FROM MILEAGE  
                    WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
                    AND MILEAGETYPE ='MILEAGESTART' 
                    ORDER BY CREATEDATE DESC";
                    $params_semileagestart = array();
                    $query_semileagestart = sqlsrv_query($conn, $sql_semileagestart, $params_semileagestart);
                    $result_semileagestart = sqlsrv_fetch_array($query_semileagestart, SQLSRV_FETCH_ASSOC);

                    $sql_semileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND'
                        FROM MILEAGE  
                        WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
                        AND MILEAGETYPE ='MILEAGEEND' 
                        ORDER BY CREATEDATE DESC";
                    $params_semileageend = array();
                    $query_semileageend  = sqlsrv_query($conn, $sql_semileageend, $params_semileageend);
                    $result_semileageend = sqlsrv_fetch_array($query_semileageend, SQLSRV_FETCH_ASSOC);

                        if ($result_seReporttransport['STATUSNUMBER'] == 'X') {
                            $remark = 'แผนงานตัดงาน';
                        }else if($result_seReporttransport['DOCUMENTCODE'] == '' || $result_seReporttransport['DOCUMENTCODE'] == 'NULL' ) {
                            $remark = 'แผนงานยังไม่คีย์ DO';
                        }else if($result_semileagestart['MILEAGESTART'] == '' ) {
                            $remark = 'แผนงานไม่คีย์เลขไมล์';
                        }else if($result_semileageend['MILEAGEEND'] == ''  ) {
                            $remark = 'แผนงานไม่คีย์เลขไมล์';
                        }else {
                            $remark= '';
                        }
                ?>

                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $result_seReporttransport['JOBNO'] ?></td>
                        <td><?= $result_seReporttransport['DOCUMENTCODE'] ?></td>
                        <td><?= $result_seReporttransport['JOBDATE'] ?></td>
                        <td>-</td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['JOBSTART'] ?></td>
                        <td><?= $result_seReporttransport['JOBEND'] ?></td>
                        <td><?= $result_seVeh['VEHICLETYPEAMOUNT'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLEREGISNUMBER1'] ?></td>
                        <td><?= $result_seReporttransport['TRIPAMOUNT'] ?></td>
                        <td><?= $result_seReporttransport['ACTUALPRICE'] ?></td>
                        <td><?= $result_seReporttransport['ACTUALPRICE'] ?></td>
                        <td><?=$result_seReporttransport['ACTUALPRICE']*$result_seReporttransport['TRIPAMOUNT']?></td>
                        <td>-</td>
                        <td><?= $result_seReporttransport['ACTUALPRICE'] ?></td>
                        <td><?= $result_seReporttransport['ACTUALPRICE']*$result_seReporttransport['TRIPAMOUNT']?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME1'] ?></td>
                        <td><?= $result_seReporttransport['COMPENSATION1'] ?></td>
                        <td><?= $result_seReporttransport['COMPENSATIONEMPTY1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME2'] ?></td>
                        <td><?= $result_seReporttransport['COMPENSATION2'] ?></td>
                        <td><?= $result_seReporttransport['COMPENSATIONEMPTY2'] ?></td>
                        <td><?= $result_semileagestart['MILEAGESTART'] ?></td>
                        <td><?= $result_semileageend['MILEAGEEND'] ?></td>
                        <td><?= $result_seReporttransport['STATUS'] ?></td>
                        <td><?= $remark ?></td>


                        
                       


                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>