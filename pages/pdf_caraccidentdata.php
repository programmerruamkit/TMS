
<?php

require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
//$mpdf = new mPDF();
$mpdf = new mPDF('th', 'A4', '0', '');

$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';

$table_begin2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;margin-top:10px;">';
$thead2 = '<thead>
      <tr  style="border:1px solid #000;padding:16px;">
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 15%;font-size:22px"><b>ลำดับ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>ทะเบียนรถ / ชื่อรถ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>ชื่อพนักงานผู้ขับรถ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>วันที่เวลาที่เกิดอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>สถานที่เกิดอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>ปัญหาจากการเกิดอุบัติเหตุ</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>สถานที่ซ่อม</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>ชื่ออู่นอก</b></td>
        <td   style="border-right:1px solid #000;padding:16px;text-align:center;background-color:#A69D9D;width: 10%;font-size:22px"><b>อาการที่ส่งซ่อม</b></td>        
      </tr>
    </thead><tbody>';
        $i = 1;
        $regiscar=$_GET['regiscar'];
        $area=$_GET['area'];

        if(($regiscar!="")&&($area!="")){
            $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
            DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
            CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
            CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
            CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
            FROM ACCIDENTHISTORY_CAR 
            LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
            LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
            WHERE RG_CAR LIKE '%".$_GET['regiscar']."%' AND AREA = '".$_GET['area']."' AND STATUS = '1'
            AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
            ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
        }else if(($regiscar=="")&&($area!="")){
            $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
            DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
            CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
            CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
            CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
            FROM ACCIDENTHISTORY_CAR 
            LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
            LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
            WHERE AREA = '".$_GET['area']."' AND STATUS = '1'
            AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
            ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
        }else if(($regiscar!="")&&($area=="")){
            $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
            DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
            CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
            CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
            CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
            FROM ACCIDENTHISTORY_CAR 
            LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
            LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
            WHERE RG_CAR LIKE '%".$_GET['regiscar']."%' AND STATUS = '1'
            AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
            ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
        }else{                                                            
            $sql_seAccidentCarData = "SELECT ACCICAR_ID,RG_CAR,THAINAME,EMP_CODE,EMP_NAME,nameT,
            DT_ACCI,LC_ACCI,PB_ACCI,RP_INOUT,RP_OUT_GR,RP_OUT_GR_PB,STATUS,
            CONVERT(VARCHAR(4),DT_ACCI,23) AS 'YEAR',
            CONVERT(VARCHAR(10),DT_ACCI,103) AS 'DATE',
            CONVERT(VARCHAR(5),CONVERT(DATETIME,DT_ACCI,0),108) AS 'TIME'
            FROM ACCIDENTHISTORY_CAR 
            LEFT JOIN VEHICLEINFO VIF ON VIF.VEHICLEREGISNUMBER = ACCIDENTHISTORY_CAR.RG_CAR 
            LEFT JOIN EMPLOYEEEHR2 EHR ON EHR.PersonCode = ACCIDENTHISTORY_CAR.EMP_CODE
            WHERE STATUS = '1' AND CONVERT(VARCHAR(4),DT_ACCI,23) BETWEEN '".$_GET['yearstart']."' AND '".$_GET['yearend']."' 
            ORDER BY CONVERT(VARCHAR(4),DT_ACCI,23),DT_ACCI ASC";
        }
        $params_seAccidentCarData = array();
        $query_seAccidentCarData = sqlsrv_query($conn, $sql_seAccidentCarData, $params_seAccidentCarData);
        while ($result_seAccidentCarData = sqlsrv_fetch_array($query_seAccidentCarData, SQLSRV_FETCH_ASSOC)) {    
            $RG_CAR=$result_seAccidentCarData['RG_CAR'];
            $THAINAME=$result_seAccidentCarData['THAINAME'];     
            if($THAINAME=='-'){
                $ifregisnamecar=$RG_CAR;
            }else{
                $ifregisnamecar=$RG_CAR.' / '.$THAINAME;
            }   
            $RP_INOUT=$result_seAccidentCarData['RP_INOUT'];     
            if($RP_INOUT=='inrepair'){
                $ifrpinout="ซ่อมใน";
            }else{
                $ifrpinout="ซ่อมนอก";
            } 
            $EMP_CODE=$result_seAccidentCarData['EMP_CODE'];
            $EMP_NAME=$result_seAccidentCarData['EMP_NAME'];
            $nameT=$result_seAccidentCarData['nameT'];      
            // if($nameT==""){
            //     $rsname=$EMP_CODE;
            // }else{
            //     $rsname=$nameT;
            // }      
            if(($nameT=="")&&($EMP_CODE=="")){
                $rsname=$EMP_NAME;
            }else if(($nameT=="")&&($EMP_CODE!="")){
                    $rsname=$EMP_CODE.'<br><small>('.$EMP_NAME.')</small>';
            }else{
                $rsname=$nameT;
            }   
        $tbody2 .= '
        <tr style="border:1px solid #000;padding:16px;">
          <td style="border-right:1px solid #000;padding:16px;text-align:center;width: 15%;font-size:20px">'.$i.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$ifregisnamecar.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$rsname.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentCarData['DATE'].' '.$result_seAccidentCarData['TIME'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentCarData['LC_ACCI'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentCarData['PB_ACCI'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$ifrpinout.'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentCarData['RP_OUT_GR'].'</td>
          <td style="border-right:1px solid #000;padding:16px;text-align:left;width: 30%;font-size:20px">'.$result_seAccidentCarData['RP_OUT_GR_PB'].'</td>          
        </tr>
        ';      
      $i++;
    }

$table_end2 = '</table>';




$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($table_end2);
// $mpdf->Output();

$mpdf->Output();


sqlsrv_close($conn);
?>
