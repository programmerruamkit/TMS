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
        <td  colspan="13"  style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รายงานประวัติการซ่อมบำรุง ประจำวันที่ ' . $_GET['datestart'] . ' - ' . $_GET['dateend'] . '</b></td>
    </tr>
        <tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;">NO</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">NICKNM</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">วันที่</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">REGNO</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">JOBNO</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">TYPNAME</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;">รายละเอียด</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">ปริมาณ</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">ราคาต่อหน่วย</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">รวมเป็นเงิน</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">SERVICEFEE</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;">NAME</td>

    </tr>
    </thead>';


    $i = 1;
    //DESC1 =รายละเอียด ,QTYBOD=ปริมาณ,NETPRC=ราคาต่อหน่วย,TOTPRC=รวมเป็นเงิน
  $REGNO = ($_GET['vehiclenumber'] == "")?"":" AND c.REGNO LIKE '" . $_GET['vehiclenumber'] . "'";
  $NAME = ($_GET['name'] == "")?"":" AND g.NAME LIKE '" . $_GET['name'] . "'";
  $DESC1 = ($_GET['desc1'] == "")? "":" AND e.DESC1 LIKE '%" . $_GET['desc1'] . "%'";
  $sql_seRepairData = "SELECT DISTINCT f.NICKNM,CONVERT(VARCHAR(10),a.TAXDATE,103)  AS 'DATE', c.REGNO, a.JOBNO ,
  b.TYPNAME, e.DESC1 AS 'DESC1', d.QTYBOD AS 'QTYBOD',
  d.NETPRC AS 'NETPRC', d.TOTPRC AS 'TOTPRC',a.TSV_TOT + a.OUTJTOT AS 'SERVICEFEE',g.NAME
  FROM [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_JOBORDER a
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SVTYPE b ON b.TYPCOD = a.REPTYPE
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SVMAST c ON a.STRNO = c.STRNO
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_SV_ORDTN d ON a.JOBNO = d.JOBNO
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].L_INVENTOR e ON d.PARTNO = e.PARTNO
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo].CUSTMAST f ON a.CUSCOD = f.CUSCOD
  INNER JOIN [203.150.29.241\SQLEXPRESS,1434].[ELASTIC].[dbo]. OFFICER g ON a.REPCOD = g.CODE
  WHERE 1=1

  AND CONVERT(DATE,a.TAXDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)" . $REGNO . $NAME . $DESC1;
    $params_seRepairData = array();
    $query_seRepairData = sqlsrv_query($conn, $sql_seRepairData, $params_seRepairData);
    while ($result_seRepairData = sqlsrv_fetch_array($query_seRepairData, SQLSRV_FETCH_ASSOC)) {



    $td .= '<tbody>

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$i.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['NICKNM'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['DATE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['REGNO'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['JOBNO'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['TYPNAME'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['DESC1'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['QTYBOD'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['NETPRC'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['TOTPRC'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['SERVICEFEE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$result_seRepairData['NAME'].'</td>


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
