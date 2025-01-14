<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$conn = connect("RTMS");

$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "รายการค่าอาหารประจำวันที่" . $_GET['datestart'] . "ถึงวันที่" . $_GET['dateend'] . ".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<style>
    input.largerCheckbox {
        width: 20px;
        height: 20px;
    }
</style>

<!-- ////////////////////////////////////////////////10W/STC///////////////////////////////////////////////// -->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <br>
        <table   style="border-collapse: collapse;margin-top:8px;font-size:10px" width="100%"  >
            <thead>
                <tr>

                    <th colspan="13" bgcolor="#666" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center;">
                        <b>รายการค่าอาหารประจำวันที่ <?= $_GET['datestart'] ?> ถึงวันที่ <?= $_GET['dateend'] ?> (ทังหมด)</b>

                    </th>

                </tr>
                <tr>

                    <th colspan="10" bgcolor="#999" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>ข้อมูลพื้นฐาน</b>

                    </th>
                    <th colspan="3" bgcolor="#999" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>ข้อมูลแผนงาน</b>

                    </th>


                </tr>


                <tr>

                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ลำดับที่</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา(ไป)</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา(กลับ)</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">บริษัท</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รหัสพนักงาน</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ชื่อ-นามสกุล</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">จำนวนเงิน</td>
                   
                    
                     <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่/เวลา(ไป)</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่/เวลา(กลับ)</td>
                    
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่เริ่มงาน</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่กลับ</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">หมายเหตุ</td>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;


                $sql_seFood = "SELECT [ID], [CurrentTel], [PositionGroup], [Tel], [Email], [PositionNameOther], 
                    [PersonID], [PersonCode], [CompanyID], [Company_Code], [Company_NameT], 
                    [Company_NameE], [LevelID], [PositionNameT], [PositionNameE], [TaxID], 
                    [InitialID], [MaritalID], [FnameT], [LnameT],[FnameT]+' '+[LnameT] AS 'nameFL', [nameT], [FnameE], 
                    [LnameE], [nameE], [BirthDate], [StartDate], [PassDate], [year], 
                    [yearwork], [yearb], [monthb], [dayb], [yearw], [monthw], [dayw], [SexID], 
                    [PositionID], [SexT], [BirthDate103], [numProof], [EndDate], [CarLicenceID], 
                    [CardTel], [StartWork] 
                    FROM EMPLOYEEEHR2 WHERE  PersonCode = '" . $_GET['employeecode'] . "' ";

                $params_seFood = array();
                $query_seFood = sqlsrv_query($conn, $sql_seFood, $params_seFood);


                while ($result_seFood = sqlsrv_fetch_array($query_seFood, SQLSRV_FETCH_ASSOC)) {
                    $x = 1;

                    $sql_seFood1 = "SELECT DATEDIFF(DAY,CONVERT(DATETIME,'" . $_GET['datestart'] . "',103),CONVERT(DATETIME,'" . $_GET['dateend'] . "',103))+1 AS 'CNT'";

                    $params_seFood1 = array();
                    $query_seFood1 = sqlsrv_query($conn, $sql_seFood1, $params_seFood1);
                    $result_seFood1 = sqlsrv_fetch_array($query_seFood1, SQLSRV_FETCH_ASSOC);

                    while ($x <= $result_seFood1['CNT']) {
                        $sql_seFood2 = "SELECT CONVERT(NVARCHAR(30),DATEADD(DAY," . ($x - 1) . ",CONVERT(DATETIME,'" . $_GET['datestart'] . "',103)),103) AS 'DATEN'";
                        $params_seFood2 = array();
                        $query_seFood2 = sqlsrv_query($conn, $sql_seFood2, $params_seFood2);
                        $result_seFood2 = sqlsrv_fetch_array($query_seFood2, SQLSRV_FETCH_ASSOC);



                        $sql_seFood3 = "{call megFoodcompensation_v2(?,?,?)}";
                        $params_seFood3 = array(
                            array('select_foodcompensation', SQLSRV_PARAM_IN),
                            array($result_seFood['PersonCode'], SQLSRV_PARAM_IN),
                            array($result_seFood2['DATEN'], SQLSRV_PARAM_IN)
                        );

                        $query_seFood3 = sqlsrv_query($conn, $sql_seFood3, $params_seFood3);
                        $result_seFood3 = sqlsrv_fetch_array($query_seFood3, SQLSRV_FETCH_ASSOC);
                        ?>


                        <tr>
                            <td style="text-align:center" ><?= $i ?></td>
                           <td ><?= $result_seFood2['DATEN'] ?></td>
                            <td ><?= $result_seFood3['TII'] ?></td>
                            <td ><?= $result_seFood3['TOO'] ?></td>
                            <td ><?= $result_seFood['Company_Code'] ?></td>
                            <td ><?= $result_seFood['PersonCode'] ?></td>
                            <td ><?= $result_seFood['nameFL'] ?></td>
                            <td ><?= $result_seFood3['MONNY'] ?></td>
                             <td ><?= $result_seFood3['TI'] ?></td>
                            <td ><?= $result_seFood3['TO'] ?></td>
                            
                            <td ><?= $result_seDaterk['DATERK'] ?></td>
                            <td ><?= $result_seDatereturn['DATERETURN'] ?></td>
                            <td ><?= $result_seFood3['REMARK'] ?></td>




                        </tr>

                        <?php
                        $x++;
                    }
                    $i++;
                }
                ?>
            </tbody>

        </table>
    </body>
</html>
