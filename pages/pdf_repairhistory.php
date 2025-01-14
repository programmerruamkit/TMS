<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}

$mpdf = new mPDF('th', 'A4-L', '0', '');
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
        <td  colspan="12"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รายงานประวัติการซ่อมบำรุง ประจำวันที่ ' . $_GET['datestart'] . ' - ' . $_GET['dateend'] . '</b></td>
    </tr>

        
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ลำดับ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">บริษัท</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">วันที่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">ทะเบียนรถ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">ช่างซ่อม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">เลข JOB</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">ชื่องานซ่อม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;">รายละเอียดงานซ่อม</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ปริมาณ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ราคาต่อหน่วย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">ราคาขาย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">รวมเป็นเงิน</td>
    </tr>
    </thead>';
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

    $td .= '<tbody>

    <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $i . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['NICKNM'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['OPENDATE'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['REGNO'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['MECHANIC'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['JOBNO'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['TYPNAME'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['SPAREPARTSDETAIL'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['NET'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['COST'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['SELLING'] . '</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">' . $result_seRepairData['SUMMARY'] . '</td>


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
