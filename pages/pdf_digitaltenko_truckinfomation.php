
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');




$sql_infolist = "SELECT a.VEHICLEINFOID, a.VEHICLEREGISNUMBER, a.VEHICLEGROUPCODE,b.VEHICLEGROUPDESC, a.VEHICLETYPECODE,c.VEHICLETYPEDESC,a.VEHICLETYPEIMAGE, 
a.BRANDCODE,d.BRANDDESC, a.GEARTYPECODE,e.GEARTYPEDESC, a.COLORCODE,f.COLORDESC, a.SERIES, a.THAINAME, a.ENGNAME, a.HORSEPOWER, a.CC, a.MACHINENUMBER, 
a.CHASSISNUMBER, a.ENERGY, a.[WEIGHT], a.MAXIMUMLOAD,
a.VEHICLEBUYWHERE,a.ACTIVESTATUS, a.REMARK, 
a.CREATEBY, a.CREATEDATE, a.MODIFIEDBY, a.MODIFIEDDATE
FROM dbo.VEHICLEINFO a
LEFT JOIN dbo.VEHICLEGROUP b ON a.VEHICLEGROUPCODE = b.VEHICLEGROUPCODE
LEFT JOIN dbo.VEHICLETYPE c ON a.VEHICLETYPECODE = c.VEHICLETYPECODE
LEFT JOIN dbo.VEHICLEBRAND d ON a.BRANDCODE = d.BRANDCODE
LEFT JOIN dbo.VEHICLEGEARTYPE e ON a.GEARTYPECODE = e.GEARTYPECODE
LEFT JOIN dbo.VEHICLECOLOR f ON a.COLORCODE = f.COLORCODE
WHERE a.ACTIVESTATUS = 1 
-- AND a.REMARK ='RKS(STM-SR)'
AND a.VEHICLEREGISNUMBER = '".$_GET['vehicleregisnumber']."'
ORDER BY a.VEHICLEREGISNUMBER ASC";
    
$params_infolist = array();
$query_infolist = sqlsrv_query($conn, $sql_infolist, $params_infolist);
$result_infolist = sqlsrv_fetch_array($query_infolist, SQLSRV_FETCH_ASSOC);

if ($result_infolist['VEHICLETYPEDESC'] == 'รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)') {
  $VEHICLETYPE1  = substr("รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)",0,37);
  $VEHICLETYPE2  = substr("รถบรรทุก 10 ล้อ(ตู้กันวิงเหล็ก)",37,44);
}else{

}
// COUNT MANTANANCE RECORD
$sql_CountMan = "SELECT COUNT(RKTCID) AS 'COUNTRKTC'
FROM [dbo].[RKTC]
WHERE  REGNO ='".$_GET['vehicleregisnumber']."'
--ORDER BY CONVERT(VARCHAR(10),OPENDATE,103) ASC
AND CONVERT(DATE,OPENDATE,103) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)";
    
$params_CountMan = array();
$query_CountMan = sqlsrv_query($conn, $sql_CountMan, $params_CountMan);
$result_CountMan = sqlsrv_fetch_array($query_CountMan, SQLSRV_FETCH_ASSOC);

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



//   $table1 .= '<tbody>

//       <tr style=" padding:4px;">
//           <td colspan="18" style=" padding:4px;text-align:left;"><hr /></td>
//       </tr>
//       <tr style="padding:4px;border-collapse: collapse" colspan="8">
//           <td  colspan="2" style=" padding:4px;text-align:left;font-size:16px;">Truck license :</td>
//           <td  colspan="8" style=" padding:4px;text-align:left;font-size:16px;">'.$result_seEmp['PersonCode'].'</td>
      
//           <td style=" padding:4px;text-align:left;font-size:16px">Truck Brand :</td>
//           <td style=" padding:4px;text-align:left;font-size:16px">'.$result_seEmp['nameT'].'</td>      
//       </tr>
//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Truck type :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">'.$result_seEmp['nameE'].'</td>
//       </tr>
//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Year :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">'.$result_seDep['DEPARTMENTNAME'].' </td>
//       </tr>

//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Chassis number :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">'.$result_seSec['SECTIONNAME'].'</td>
//       </tr>
//        <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Truck model :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">'.$result_seEmp['PositionNameT'].' </td>
//       </tr>
//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Truck weight :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">-</td>
//       </tr>
//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Loading weight capacity :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">-</td>
//       </tr>

//       <tr style=" padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Truck dimension : L x W x H</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">-</td>
//       </tr>
//        <tr style="#000;padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Cargo dimension : L x W x H</td>
//         <td style=" padding:4px;text-align:left;font-size:16px"></td>
        
//       </tr>
//        <tr style="#000;padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Fuel tank capacity :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">-</td>
//       </tr>
//        <tr style="#000;padding:4px;">
//         <td style=" padding:4px;text-align:left;font-size:16px">Speed limit setting (km/hr) :</td>
//         <td style=" padding:4px;text-align:left;font-size:16px">-</td>
//       </tr>
//        <tr>
//        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
//        <td colspan="2" rowspan="7" style=" padding:4px;text-align:center;width: 15%"><img width="20%" src="../images/employee/'.$result_seEmp['PersonCode'].'.JPG"></td>
//        </tr>
// </tbody></table>';

// Truck Infomation
$table_header1 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td width="100%" style="text-align:center;font-size:16px"><b>TRUCK INFORMATION</b></td>
        </tr>

    </thead>
</table>';
$table_begin1 = '<table  id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead1 = '<thead >

      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width: 25%"><b>Truck license :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width: 25%"><b>'.$result_infolist['VEHICLEREGISNUMBER'].'</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width: 26%"><b>Truck brand :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width: 24%"><b>'.$result_infolist['BRANDDESC'].'</b></td>
      </tr>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>Truck type :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b><b>'.$VEHICLETYPE1.'<br>'.$VEHICLETYPE2.'</b></b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 26%"><b>Year :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 24%"><b></b></td>
      </tr>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>Chassis number :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>'.$result_infolist['CHASSISNUMBER'].'</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 26%"><b>Truck model :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 24%"><b></b></td>
      </tr>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>Truck weight :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>'.$result_infolist['WEIGHT'].'</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 26%"><b>Loading weight capacity :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 24%"><b>'.$result_infolist['MAXIMUMLOAD'].'</b></td>
      </tr>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>Truck dimension : L x W x H</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b></b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 26%"><b>Cargo dimension : L x W x H</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 24%"><b></b></td>
      </tr>
      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b>Fuel tank capacity :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 25%"><b></b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 26%"><b>Speed limit setting (km/hr) :</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:left;font-size:12px;width= 24%"><b></b></td>
      </tr>
    </thead>'; 
$tfoot1 = '</tbody><tfoot>
<tr style="border:1px solid #000;">
    <td  colspan="9" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:20px"><img width="40%" src="../images/DigitalTenko_Truck/'.$_GET['vehicleregisnumber'].'/F.jpg"></td>
</tr>
<tr style="border:1px solid #000;">
    <td  colspan="9" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:20px"><img width="40%" src="../images/DigitalTenko_Truck/'.$_GET['vehicleregisnumber'].'/B.jpg"></td>
</tr>
<tr style="border:1px solid #000;">
    <td  colspan="9" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:20px"><img width="40%" src="../images/DigitalTenko_Truck/'.$_GET['vehicleregisnumber'].'/SL.jpg"></td>
</tr>
<tr style="border:1px solid #000;">
    <td  colspan="9" style="border-right:1px solid #000;padding:11px;text-align:center;font-size:20px"><img width="40%" src="../images/DigitalTenko_Truck/'.$_GET['vehicleregisnumber'].'/SR.jpg"></td>
</tr>
</tfoot>';
$table_end1 = '</table>';

// Maintenance record
if ($result_CountMan['COUNTRKTC'] > 0) {
  $table_header3 = '<table style="width: 110%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>Maintenance record ช่วงวันที่ '.$_GET['startdate'].' ถึง '.$_GET['enddate'].'</b></td>
        </tr>

    </thead>
</table>';
}else {
  $table_header3 = '<table style="width: 110%;">
    <thead>
        <tr>
            <td colspan="48" style="text-align:center;font-size:16px"><b>ยังไม่มี Maintenance record ช่วงวันที่ '.$_GET['startdate'].' ถึง '.$_GET['enddate'].'</b></td>
        </tr>

    </thead>
</table>';
}
// $table_header3 = '<table style="width: 110%;">
//     <thead>
//         <tr>
//             <td colspan="48" style="text-align:center;font-size:16px"><b>Maintenance record</b></td>
//         </tr>

//     </thead>
// </table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:8px;">';
$thead3 = '<thead>

      <tr  style="border:1px solid #000;padding:8px;">
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 10%;font-size:12px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size:12px"><b>วันที่</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>ประเภทการซ่อม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>รายละเอียด</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 30%;font-size:12px"><b>ช่างซ่อม</b></td>
        <td   style="border-right:1px solid #000;padding:8px;text-align:center;width: 25%;font-size:12px"><b>หมายเหตุ</b></td>
      </tr>
    </thead><tbody>';
    $i = 1;
    $count = 0 ;
    $sql_sedata = "SELECT CONVERT(VARCHAR(10),OPENDATE,103) AS 'OPENDATE',
    TYPNAME AS 'TYPNAME',SPAREPARTSDETAIL AS 'DETAIL',MECHANIC AS 'MEC'
    FROM [dbo].[RKTC]
    WHERE  REGNO ='".$_GET['vehicleregisnumber']."'
    --ORDER BY CONVERT(VARCHAR(10),OPENDATE,103) ASC
    AND CONVERT(DATE,OPENDATE,103) BETWEEN CONVERT(DATE,'".$_GET['startdate']."',103) AND CONVERT(DATE,'".$_GET['enddate']."',103)
    ORDER BY CONVERT(DATE,OPENDATE,103) ASC";
    $params_sedata = array();
    
    
    
    $query_sedata = sqlsrv_query($conn, $sql_sedata, $params_sedata);
    while ($result_sedata = sqlsrv_fetch_array($query_sedata, SQLSRV_FETCH_ASSOC)) {

        $tbody3 .= '
      <tr style="border:1px solid #000;padding:10px;">
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 15%;font-size:12px">'.$i.'</td>
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 25%;font-size:12px">'.$result_sedata['OPENDATE'].'</td>
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 25%;font-size:12px">'.$result_sedata['TYPNAME'].'</td>
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 25%;font-size:12px">'.$result_sedata['DETAIL'].'</td>
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 25%;font-size:12px">'.$result_sedata['MEC'].'</td>
        <td style="border-right:1px solid #000;padding:10px;text-align:center;width: 25%;font-size:12px"></td>
      </tr>';
      $i++;
    }

$table_end3 = '</table>';





$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->AddPage();
if ($result_CountMan['COUNTRKTC'] > 0) {
  $mpdf->WriteHTML($table_header3);
  $mpdf->WriteHTML($table_begin3);
  $mpdf->WriteHTML($thead3);
  $mpdf->WriteHTML($tbody3);
  // $mpdf->WriteHTML($tfoot3);
  $mpdf->WriteHTML($table_end3);
}else {
  $mpdf->WriteHTML($table_header3);
  // $mpdf->WriteHTML($table_begin3);
  // $mpdf->WriteHTML($thead3);
  // $mpdf->WriteHTML($tbody3);
  // // $mpdf->WriteHTML($tfoot3);
  // $mpdf->WriteHTML($table_end3);
}

$mpdf->Output();

sqlsrv_close($conn);
?>
