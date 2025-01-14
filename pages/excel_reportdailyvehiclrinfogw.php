<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");

    $strExcelFileName = "รายงานตรวจรถประจำวัน ประจำวันที่".$_GET['datestart']."xls";



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
                    <td colspan="8" style="text-align: center"><b>รายงานตรวจรถประจำวัน ประจำวันที่ <?=$_GET['datestart']?></b></td>
                </tr>
                <tr>
                    <th><label style="width: 50px">ลำดับ</label></th>
                    <th><label style="width: 200px">วันที่</label></th>
                    <th><label style="width: 200px">ประเภทรถ</label></th>
                    <th><label style="width: 200px">ทะเบียน</label></th>
                    <th><label style="width: 200px">ชื่อรถ(ไทย)</label></th>
                    <th><label style="width: 200px">ชื่อรถ(ENG)</label></th>
                    <th><label style="width: 200px">เลขไมล์ต้น</label></th>
                    <th><label style="width: 200px">เลขไมล์ปลาย</label></th>



                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
               $sql_getCar = "SELECT DISTINCT a.VEHICLEREGISNUMBER,c.VEHICLETYPEDESC, a.THAINAME, a.ENGNAME,
                                                                        CONVERT(NVARCHAR(10),GETDATE(),103) AS 'SYSDATE'
                                                                        FROM VEHICLEINFO a
                                                                        LEFT JOIN dbo.VEHICLETYPE c ON a.VEHICLETYPECODE = c.VEHICLETYPECODE
                                                                        WHERE a.ACTIVESTATUS = 1
                                                                        AND (a.THAINAME LIKE '%R-%' OR a.THAINAME LIKE '%RA-%' OR a.THAINAME LIKE '%RP-%'
                                                                        OR a.THAINAME LIKE '%คลองเขื่อน%'  OR a.THAINAME LIKE '%ด่านช้าง%'  OR a.THAINAME LIKE '%สวนผึ้ง%'
                                                                        OR a.ENGNAME LIKE '%ดินแดง%' OR a.ENGNAME LIKE '%อุทัยธานี%' OR a.ENGNAME LIKE '%Kerry%'
                                                                        OR a.THAINAME LIKE '%เขาชะเมา%' OR a.THAINAME LIKE '%เฉลิมพระเกียรติ%' OR a.THAINAME LIKE '%P35%' )
                                                                        ";
                                                                        $params_getCar = array();
                                                                        $query_getCar = sqlsrv_query($conn, $sql_getCar, $params_getCar);
                                                                        while ($result_getCar = sqlsrv_fetch_array($query_getCar, SQLSRV_FETCH_ASSOC)) {

                    $sql_getMilestart = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),'" . $_GET['datestart'] . "',103)
                                                                            AND MILEAGETYPE = 'MILEAGESTART' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                    $params_getMilestart = array();
                    $query_getMilestart = sqlsrv_query($conn, $sql_getMilestart, $params_getMilestart);
                    $result_getMilestart = sqlsrv_fetch_array($query_getMilestart, SQLSRV_FETCH_ASSOC);

                    $sql_getMileend = "SELECT MAX(MILEAGENUMBER) AS 'MILEAGENUMBER' FROM [dbo].[MILEAGE] WHERE CONVERT(NVARCHAR(10),CREATEDATE,103) = CONVERT(NVARCHAR(10),'" . $_GET['datestart'] . "',103)
                                                                            AND MILEAGETYPE = 'MILEAGEEND' AND VEHICLEREGISNUMBER = '" . $result_getCar['VEHICLEREGISNUMBER'] . "'";
                    $params_getMileend = array();
                    $query_getMileend = sqlsrv_query($conn, $sql_getMileend, $params_getMileend);
                    $result_getMileend = sqlsrv_fetch_array($query_getMileend, SQLSRV_FETCH_ASSOC);
                    ?>
                    <tr>
                        <td style="text-align: center"><?= $i ?></td>    
                        <td style="text-align: center"><?= $result_getCar['SYSDATE'] ?></td>
                        <td style="text-align: center"><?= $result_getCar['VEHICLETYPEDESC'] ?></td>
                        <td style="text-align: center"><?= $result_getCar['VEHICLEREGISNUMBER'] ?></td>
                        <td style="text-align: center"><?= $result_getCar['THAINAME'] ?></td>
                        <td style="text-align: center"><?= $result_getCar['ENGNAME'] ?></td>
                        <td style="text-align: center"><?= number_format($result_getMilestart['MILEAGENUMBER']) ?></td>
                        <td style="text-align: center"><?= number_format($result_getMileend['MILEAGENUMBER'])  ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
