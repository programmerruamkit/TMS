<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}

$mpdf = new mPDF('th', 'A3-L', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_begin = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$tr = '
    <thead>
    <tr style="border:1px solid #000;padding:4px;">
        <td  colspan="17"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รายงานการแจ้งซ่อม ประจำวันที่ ' . $date_now . '</b></td>
    </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">DRIVER</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">SECTION</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">ISSUE</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">เจ้าหน้าที่.TENKO</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" colspan="3">ก่อนแก้ไข</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" colspan="3">หลังแก้ไข</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">สาเหตุ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">การแก้ไข</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;" rowspan="2">การป้องกัน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">ช่างผู้รับผิดชอบ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">ผู้รับแจ้งซ่อม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;" rowspan="2">กำหนดเสร็จ</td>
        
    </tr>
     <tr>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGBEORE(1)</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGBEORE(2)</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGBEORE(3)</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGAFTER(1)</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGAFTER(2)</td>
                                                            <td style="border-right:1px solid #000;padding:4px;text-align:center;">IMGAFTER(3)</td>
                                                          
                                                            
                                                        </tr>
    </thead>';


$condRepair1 = " AND convert(date,CREATEDATE) BETWEEN convert(date, '" . $_GET['datestart'] . "', 103) AND convert(date, '" . $_GET['dateend'] . "', 103)";
$sql_seRepair1 = "{call megRepair_v2(?,?)}";
$params_seRepair1 = array(
    array('select_repair', SQLSRV_PARAM_IN),
    array($condRepair1, SQLSRV_PARAM_IN)
);


$i = 1;
$td = '';
$query_seRepair1 = sqlsrv_query($conn, $sql_seRepair1, $params_seRepair1);
while ($result_seRepair1 = sqlsrv_fetch_array($query_seRepair1, SQLSRV_FETCH_ASSOC)) {
    $sql_seImgbefore1 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 1";
                                                            $params_seImgbefore1 = array();
                                                            $query_seImgbefore1 = sqlsrv_query($conn, $sql_seImgbefore1, $params_seImgbefore1);
                                                            $result_seImgbefore1 = sqlsrv_fetch_array($query_seImgbefore1, SQLSRV_FETCH_ASSOC);
                                                            
                                                            $sql_seImgbefore2 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 2";
                                                            
                                                            $params_seImgbefore2 = array();
                                                            $query_seImgbefore2 = sqlsrv_query($conn, $sql_seImgbefore2, $params_seImgbefore2);
                                                            $result_seImgbefore2 = sqlsrv_fetch_array($query_seImgbefore2, SQLSRV_FETCH_ASSOC);
                                                           
                                                            
                                                            
                                                            $sql_seImgbefore3 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRBEFOREID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_BEFORE] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 3";
                                                            $params_seImgbefore3 = array();
                                                            $query_seImgbefore3 = sqlsrv_query($conn, $sql_seImgbefore3, $params_seImgbefore3);
                                                            $result_seImgbefore3 = sqlsrv_fetch_array($query_seImgbefore3, SQLSRV_FETCH_ASSOC);
                                                            
                                                            
                                                            
                                                            
                                                            $sql_seImgaffter1 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 1";
                                                            $params_seImgaffter1 = array();
                                                            $query_seImgaffter1 = sqlsrv_query($conn, $sql_seImgaffter1, $params_seImgaffter1);
                                                            $result_seImgaffter1 = sqlsrv_fetch_array($query_seImgaffter1, SQLSRV_FETCH_ASSOC);
                                                            
                                                            $sql_seImgaffter2 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 2";
                                                            $params_seImgaffter2 = array();
                                                            $query_seImgaffter2 = sqlsrv_query($conn, $sql_seImgaffter2, $params_seImgaffter2);
                                                            $result_seImgaffter2 = sqlsrv_fetch_array($query_seImgaffter2, SQLSRV_FETCH_ASSOC);
                                                            
                                                            $sql_seImgaffter3 = "SELECT IMAGESPATH
                                                            FROM
                                                                (SELECT
                                                                        ROW_NUMBER () OVER (ORDER BY IMAGESREPAIRAFTERID) AS RowNum,IMAGESPATH
                                                                  FROM
                                                                        [RTMS].[dbo].[IMAGESREPAIR_AFTER] WHERE [EMPLOYEEREPAIRID] = '" . $result_seRepair1['EMPLOYEEREPAIRID'] . "'
                                                                ) sub
                                                            WHERE
                                                            RowNum = 3";
                                                            $params_seImgaffter3 = array();
                                                            $query_seImgaffter3 = sqlsrv_query($conn, $sql_seImgaffter3, $params_seImgaffter3);
                                                            $result_seImgaffter3 = sqlsrv_fetch_array($query_seImgaffter3, SQLSRV_FETCH_ASSOC);
    ?>

    <?php

    $td .= '<tbody>
         
        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['DRIVERNAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">-</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TENKO_ISSUE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TENKO_INFROM'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgbefore1['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgbefore2['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgbefore3['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgaffter1['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgaffter2['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><img src="uploads/' . $result_seImgaffter3['IMAGESPATH'] . '" width="50"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_CAUSE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_EDIT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_PROTECT'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_TECHNICIAN'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_INFROM'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepair1['TEC_COMPLETED'] . '</td>

    </tr></tbody>';
    $i++;
}
$table_end = '</table>';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output();

sqlsrv_close($conn);
?>

