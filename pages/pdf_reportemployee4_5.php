
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');
$area = ($_GET['area'] == 'amata') ? " AND a.COMPANYCODE IN ('RKS','RKR','RKL')" : " AND a.COMPANYCODE IN ('RATC','RCC','RRC')";
$emp = ($_GET['employee'] != "") ? " AND a.EMPLOYEENAME1 LIKE '%" . $_GET['employee'] . "%'" : "";
$conditionPlain = " AND CONVERT(DATE,a.DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";

$status = "";
if ($_GET['status'] != "") {
    if ($_GET['status'] == "T1") {
        $status = " AND a.STATUSNUMBER IN ('P','L','O')";
    } else if ($_GET['status'] == "T2") {
        $status = " AND a.STATUSNUMBER IN ('1','T')";
    } else {
        $status = " AND a.STATUSNUMBER = '2'";
    }
}

 $sql_sePlain = "{call megVehicletransportplan_v2(?,?)}";
                $params_sePlain = array(
                    array('select_vehicletransportplan', SQLSRV_PARAM_IN),
                    array($conditionPlain . $status . $emp . $area, SQLSRV_PARAM_IN)
                );
                $query_sePlain = sqlsrv_query($conn, $sql_sePlain, $params_sePlain);
                

               
    $style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';


    $table_1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:8;margin-top:8px;">
<thead>
<tr style="border:1px solid #000;padding:4px;">
     <th colspan="6" style="border-right:1px solid #000;padding:4px;text-align:left;"><b>รายงานเอกสารเท็งโกะประจำวันที่ '. $_GET['datestart'].'-'.$_GET['dateend'].'</b></th>
    </tr>
    <tr style="border:1px solid #000;padding:4px;">
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">ลำดับ</th>
     <th style="border-right:1px solid #000;padding:4px;text-align:center;">บริษัท</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อรถ</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">Job No</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">ชื่อ-นามสกุล</th>
        <th style="border-right:1px solid #000;padding:4px;text-align:center;">สถานะเท็งโกะ</th>

    </tr>
    </thead> 
    <tbody>';
    $i = 1;
    while ($result_sePlain = sqlsrv_fetch_array($query_sePlain, SQLSRV_FETCH_ASSOC)) {
     $status = "";   
    switch ($result_sePlain['STATUSNUMBER']) {
                                case 'O': {
                                        $status = 'เท็งโกะก่อนเริ่มงาน';
                                    }
                                    break;
                                case 'L': {
                                        $status = 'เท็งโกะก่อนเริ่มงาน';
                                    }
                                    break;
                                case 'P': {
                                        $status = 'เท็งโกะก่อนเริ่มงาน';
                                    }
                                    break;
                                case 'T': {
                                        $status = 'เท็งโกะระหว่างทาง';
                                    }
                                    break;
                                case '1': {
                                        $status = 'เท็งโกะระหว่างทาง';
                                    }
                                    break;
                                case '2': {
                                        $status = 'เท็งโกะเลิกงาน';
                                    }
                                    break;
                            }
    $table_1 .= '<tr style="border:1px solid #000;padding:4px;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">'.$i.'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_sePlain['COMPANYCODE'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_sePlain['THAINAME'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_sePlain['JOBNO'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$result_sePlain['EMPLOYEENAME1'].'</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:left;">'.$status.'</td>

      </tr>';
    $i++;
    }
    
    $table_1 .='</tbody></table>';


    $mpdf->WriteHTML($style);
    $mpdf->WriteHTML($table_1);


    $mpdf->Output();

    sqlsrv_close($conn);
    ?>

