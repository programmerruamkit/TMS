
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');



// $currentyear = date("Y");
// $sql_seCountAccident = "SELECT  COUNT(ACCI_ID) AS 'COUNTACCI'
// FROM [dbo].[ACCIDENTHISTORY]
// WHERE DRIVERCODE ='".$_GET['drivercode']."'";
// $query_seCountAccident = sqlsrv_query($conn, $sql_seCountAccident, $params_seCountAccident);
// $result_seCountAccident = sqlsrv_fetch_array($query_seCountAccident, SQLSRV_FETCH_ASSOC);



$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


// ประวัติข้อมูลอุบัติเหตุ

  $table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ข้อมูลอุบัติเหตุปี&#160;'.$_GET['yearstart'].' ถึง&#160; '.$_GET['yearend'].' </b></td>
        </tr>

    </thead>
</table>';


$table_begin2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:10px;">';
$thead2 = '<thead>
      <tr  style="border:1px solid #000;padding:16px;">
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 15%;font-size:22px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>ชื่อพนักงาน</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>วันที่และเวลา</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 35%;font-size:22px"><b>สถานที่เกิดอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 35%;font-size:22px"><b>ปัญหาของอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>MAN</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>METHOD</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>MECHINE</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 30%;font-size:22px"><b>ENVIRONMENT</b></td>
        
      </tr>
    </thead><tbody>';
    $iAccident = 1;
    
    $sql_seAccidentData = "SELECT DRIVERNAME,YEARS,CONVERT(VARCHAR(10),DATETIMEACCIDENT,103) AS 'DATE',
        CONVERT(VARCHAR(5),CONVERT(DATETIME, DATETIMEACCIDENT, 0), 108) AS 'TIME',
        DATETIMEACCIDENT,LOCATIONACCIDENT,PROBLEMACCIDENT,
        DETAILMAN,DETAILMETHOD,DETAILMECHINE,DETAILENVIRONMENT,REMARK,TYPEACCIDENT
        FROM ACCIDENTHISTORY
        WHERE YEARS BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."'
        ORDER BY YEARS,DATETIMEACCIDENT ASC";
    $params_seAccidentData = array();
    $query_seAccidentData = sqlsrv_query($conn, $sql_seAccidentData, $params_seAccidentData);
    while ($result_seAccidentData = sqlsrv_fetch_array($query_seAccidentData, SQLSRV_FETCH_ASSOC)) {
        // echo $result_sedataHealth['DIABETES'] == '0' ? 'UNCHECK'  : 'CHECK';
        $tbody2 .= '
        <tr style="border:1px solid #000;padding:16px;">
          <td style="border-right:1px solid #000;padding:16px;text-align:center;width: 15%;font-size:20px">'.$iAccident.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seAccidentData['DRIVERNAME'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DATE'].' '.$result_seAccidentData['TIME'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seAccidentData['LOCATIONACCIDENT'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 35%;font-size:20px">'.$result_seAccidentData['PROBLEMACCIDENT'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMAN'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMETHOD'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILMECHINE'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentData['DETAILENVIRONMENT'].'</td>
          
        </tr>
        ';
      
      $iAccident++;
    }

$table_end2 = '</table>';


$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($table_end2);
    // $mpdf->Output();




$mpdf->Output();


sqlsrv_close($conn);
?>
