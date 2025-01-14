<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
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

                    <th colspan="8" bgcolor="#B7DEE8" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>รายการค่าอาหารประจำวันที่ <?= $_GET['datestart'] ?> ถึงวันที่ <?= $_GET['dateend'] ?> (ละเอียด)</b> 
                     
                    </th>

                </tr>

                <tr>
                    
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ลำดับที่</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">บริษัท</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">กลุ่มพนักงาน</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">วันที่</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลาเข้า(เข้า)</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">เวลา(ออก)</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">รหัสพนักงาน</td>
                    <td bgcolor="#D9D9D9"  style="border:1px solid #000;padding:4px;text-align:center">ชื่อ-นามสกุล</td>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $PositionGroup = ($_GET['employeegroup'] != "") ? " AND d.PositionGroup ='" . $_GET['employeegroup'] . "'" : "";
               
                $sql_seFood = "SELECT 
                c.Company_NameT,
                CONVERT(NVARCHAR(10),a.TimeInout,103) AS 'TimeInout',
                CASE WHEN a.InOutMode = 'I' THEN CONVERT(NVARCHAR(5),CONVERT(TIME,a.TimeInout,103))+'('+a.InOutMode+')' ELSE '' END AS 'TimeInout_i',
                CASE WHEN a.InOutMode = 'O' THEN CONVERT(NVARCHAR(5),CONVERT(TIME,a.TimeInout,103))+'('+a.InOutMode+')' ELSE '' END AS 'TimeInout_o',
                b.PersonCode,(b.FnameT+' '+b.LnameT) AS 'FLname',d.PositionGroup
                FROM [203.150.225.30].[TigerWebServer].[dbo].[ZFP_TimeInOut] a
                INNER JOIN [203.150.225.30].[TigerE-HR].dbo.PNT_Person b ON a.PersonCardID = b.PersonCardID
                INNER JOIN dbo.COMPANYEHR c on b.CompanyID = c.ID_Company 
                INNER JOIN dbo.POSITIONEHR d ON b.PositionID = d.PositionID
                WHERE CONVERT(DATE,TimeInOut,103) BETWEEN CONVERT(DATE,'".$_GET['datestart']."',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)
                AND b.FnameT != 'ทดสอบ' AND b.PersonCode NOT IN (SELECT PNT_Person.PersonCode FROM [203.150.225.30].[TigerE-HR].[dbo].PNT_Resign 
                INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNM_ResignType ON PNT_Resign.ResignTypeID = PNM_ResignType.ResignTypeID 
                LEFT OUTER JOIN [203.150.225.30].[TigerE-HR].[dbo].PNT_Person ON PNT_Resign.PersonID = PNT_Person.PersonID WHERE PNM_ResignType.ResignT !='เกษียณอายุ') 
                AND b.FnameT+' '+b.LnameT NOT IN (SELECT [EMPLOYEENAMEF]+' '+[EMPLOYEENAMEL] FROM [203.150.225.30].[TigerE-HR].[dbo].EMPLOYEEOUT) 
                AND b.EndDate IS NULL
                AND b.ResignStatus = '1'
                AND b.ChkDeletePerson = '1'
                AND c.Company_Code = '" . $_GET['companycode'] . "' " . $PositionGroup." ORDER BY a.TimeInout ASC";

                $params_seFood = array();
                $query_seFood = sqlsrv_query($conn, $sql_seFood, $params_seFood);


                while ($result_seFood = sqlsrv_fetch_array($query_seFood, SQLSRV_FETCH_ASSOC)) {
                    
                    ?>
                        <tr>
                            <td style="text-align:center" ><?= $i ?></td>
                            <td ><?= $result_seFood['Company_NameT'] ?></td>
                            <td ><?= $result_seFood3['PositionGroup'] ?></td>
                            <td ><?= $result_seFood['TimeInout'] ?></td>
                            <td ><?= $result_seFood['TimeInout_i'] ?></td>
                            <td ><?= $result_seFood['TimeInout_o'] ?></td>
                            <td ><?= $result_seFood['PersonCode'] ?></td>
                            <td ><?= $result_seFood['FLname'] ?></td>

                        </tr>
                        <?php
                      
                    $i++;
                }
                ?>


            </tbody>

        </table>
    </body>
</html>
