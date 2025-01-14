<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);
date_default_timezone_set("Asia/Bangkok");
$conn = connect("RTMS");


// $condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
// $sql_seComp = "{call megCompany_v2(?,?)}";
// $params_seComp = array(
//     array('select_company', SQLSRV_PARAM_IN),
//     array($condition2, SQLSRV_PARAM_IN)
// );
// $query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
// $result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

// $date1 = $_GET['datebilling'];
// $date1split =  explode(",", $date1);
// echo $date1split[0];




// $sql_TempDay = "{call megClashAdv(?,?,?,?,?,?,?,?,?,?,?,?)}";
// $params_TempDay = array(
//     array('select_tempday', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array($_GET['datebilling'], SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN),
//     array('', SQLSRV_PARAM_IN)
//     );
// $query_TempDay = sqlsrv_query($conn, $sql_TempDay, $params_TempDay);
// $result_TempDay = sqlsrv_fetch_array($query_TempDay, SQLSRV_FETCH_ASSOC);

// $sql_daychk = "SELECT DAY_ADV AS 'DAY' FROM TEMP_DAYADV";
// $params_daychk = array();
// $query_daychk = sqlsrv_query($conn, $sql_daychk, $params_daychk);
// $result_daychk = sqlsrv_fetch_array($query_daychk , SQLSRV_FETCH_ASSOC);

$day= $_GET['dateheadmonth'];
$daysplit = explode(",", $day);

$week1 = $_GET['dateweek1'];
$week1split = explode(",", $week1);

$week2 = $_GET['dateweek2'];
$week2split = explode(",", $week2);

$week3 = $_GET['dateweek3'];
$week3split = explode(",", $week3);

$week4 = $_GET['dateweek4'];
$week4split = explode(",", $week4);

$week5 = $_GET['dateweek5'];
$week5split = explode(",", $week5);

if ($daysplit[1] == '') {
    $monthhead = substr($daysplit[0],3,2);
    $year = substr($daysplit[0],6,10);
    $yearhead = ($year + 543);
}else if ($daysplit[2] == '') {
    $monthhead = substr($daysplit[1],3,2);
    $year = substr($daysplit[1],6,10);
    $yearhead = ($year + 543);
}else if($daysplit[3] == ''){
    $monthhead = substr($daysplit[2],3,2);
    $year = substr($daysplit[2],6,10);
    $yearhead = ($year + 543);
}else if($daysplit[4] == ''){
    $monthhead = substr($daysplit[2],3,2);
    $year = substr($daysplit[2],6,10);
    $yearhead = ($year + 543);
}else {
    $monthhead = substr($daysplit[4],3,2);
    $year = substr($daysplit[4],6,10);
    $yearhead = ($year + 543);
}




$mm = "";
switch ($monthhead) {
    case '1': {
            $mm = "มกราคม";
        }
        break;
    case '2': {
            $mm = "กุมภาพันธ์";
        }
        break;
    case '3': {
            $mm = "มีนาคม";
        }
        break;
    case '4': {
            $mm = "เมษายน";
        }
        break;
    case '5': {
            $mm = "พฤษภาคม";
        }
        break;
    case '6': {
            $mm = "มิถุนายน";
        }
        break;
    case '7': {
            $mm = "กรกฎาคม";
        }
        break;
    case '8': {
            $mm = "สิงหาคม";
        }
        break;
    case '9': {
            $mm = "กันยายน";
        }
        break;
    case '10': {
            $mm = "ตุลาคม";
        }
        break;
    case '11': {
            $mm = "พฤศจิกายน";
        }
        break;
    default : {
            $mm = "ธันวาคม";
        }
        break;
}


$strExcelFileName = "รายงานเบิกล่วงหน้า(เดือน".$mm .").xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

?>
<style>
    body{
        font-family: "Garuda";
    }
</style>
<table width="100%" >
<tbody>
   <tr>
   <!-- <td><?=$week1split['0']?></td>
   <td><?=$week4split['1']?></td> -->
      <td colspan="9" style="text-align:center;font-size:18px"><b>พนักงานที่จะประสงค์เบิกเงินล่วงหน้าประจำเดือน จำนวน 1,000 บาท</b></td>
   </tr>
   <tr>
   <?php
    if ($_GET['companycode'] == '00') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b></b></td>
     <?php
    }else if ($_GET['companycode'] == '01') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง (1993) จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '02') {
     ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง เซอร์วิส จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '04') {
     ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง คาร์ แคริเออร์ จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '05') {
     ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจ รีไซเคิล แคริเออร์ จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '06') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง ทรัค ดีเทลส์ จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '07') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง โลจิสติคส์ จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '08') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจรุ่งเรือง เทรนนิ่ง เซ็นเตอร์ จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '09') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจ ออโตโมทีฟ ทรานสปอร์ต จำกัด</b></td>
    <?php
    }else if ($_GET['companycode'] == '10') {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>บริษัท ร่วมกิจ ไอที จำกัด</b></td>
    <?php
    }else {
    ?>
    <td colspan="9" style="text-align:center;font-size:18px"><b>ELSE CASE</b></td>
    <?php
    }
    ?>
   </tr>
   <tr>
      <td colspan="9" style="text-align:center;font-size:18px"><b>หักเงินเดือน &nbsp;&nbsp;<?=$mm?>&nbsp;&nbsp; <?=$yearhead?></b></td>
   </tr>
</tbody>
</table>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">
    <thead>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รหัสพนักงาน</b>
            </td>
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อ-สกุล</b>
            </td>
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ตำแหน่ง</b>
            </td>

            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b><?=$daysplit[0]?></b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b><?=$daysplit[1]?></b>
            </td>
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b><?=$daysplit[2]?></b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b><?=$daysplit[3]?></b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b><?=$daysplit[4]?></b>
            </td>
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>รวม</b>
            </td>
            <td   style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลงชื่อ</b>
            </td>
            

        </tr>

    </thead><tbody>
<?php
$i = 1;
        
// หาข้อมูล employeecode และ employeename จาก วันแรกของ week1 ถึงวันสุดท้าย ของ week4
if ($_GET['companycode'] == '00') {
// หา employeecode , employeename ของ week1 ถึง week4 ,00 คือ พนักงานทุกบริษัท
    if ($_GET['dateweek5'] != '') {
        $sql_seData = " SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME
                FROM [dbo].[CLASHADVANCE] 
                WHERE CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATETIME,'".$week1split[0]."',103) 
                AND CONVERT(DATETIME,'".$week5split[1]."',103) 
                AND STATUS_ADV ='A' 
                AND ACTIVESTATUS ='1'
                ORDER BY EMPLOYEECODE ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);
    }else{
        $sql_seData = " SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME
                FROM [dbo].[CLASHADVANCE] 
                WHERE CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATETIME,'".$week1split[0]."',103) 
                AND CONVERT(DATETIME,'".$week4split[1]."',103) 
                AND STATUS_ADV ='A' 
                AND ACTIVESTATUS ='1'
                ORDER BY EMPLOYEECODE ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData);

    }
            
}else {
    // หา employeecode , employeename ของ week1 ถึง week4 พนักงานทุกบริษัทตาม companycode
    if ($_GET['dateweek5'] != '') {
        $sql_seData = " SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME
                FROM [dbo].[CLASHADVANCE] 
                WHERE CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATETIME,'".$week1split[0]."',103) 
                AND CONVERT(DATETIME,'".$week5split[1]."',103) 
                AND STATUS_ADV ='A'
                AND ACTIVESTATUS ='1'
                AND SUBSTRING(EMPLOYEECODE,0,3) ='" .$_GET['companycode']. "' 
                ORDER BY EMPLOYEECODE ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData); 
    }else{
        $sql_seData = " SELECT DISTINCT EMPLOYEECODE,EMPLOYEENAME
                FROM [dbo].[CLASHADVANCE] 
                WHERE CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATETIME,'".$week1split[0]."',103) 
                AND CONVERT(DATETIME,'".$week4split[1]."',103) 
                AND STATUS_ADV ='A'
                AND ACTIVESTATUS ='1'
                AND SUBSTRING(EMPLOYEECODE,0,3) ='" .$_GET['companycode']. "' 
                ORDER BY EMPLOYEECODE ASC";
        $query_seData = sqlsrv_query($conn, $sql_seData, $params_seData); 
    }
          
}

while ($result_seData = sqlsrv_fetch_array($query_seData, SQLSRV_FETCH_ASSOC)) {

    // หาข้อมูล WEEK1
    if ($_GET['dateweek1'] != '') {
        $sql_seDay1 = "SELECT CLASHID,EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV
                    FROM [dbo].[CLASHADVANCE]
                    WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,'" .$week1split[0]. "',103) 
                    AND CONVERT(DATE,'" .$week1split[1]. "',103)
                    AND STATUS_ADV ='A'
                    AND ACTIVESTATUS ='1'
                    AND EMPLOYEECODE ='".$result_seData['EMPLOYEECODE']."' ";
        $query_seDay1 = sqlsrv_query($conn, $sql_seDay1, $params_seDay1);
        $result_seDay1 = sqlsrv_fetch_array($query_seDay1, SQLSRV_FETCH_ASSOC);
    }else{
        
    }
    
    // หาข้อมูล WEEK2
    if ($_GET['dateweek2'] != '') {
        $sql_seDay2 = "SELECT CLASHID,EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV
                    FROM [dbo].[CLASHADVANCE]
                    WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,'" .$week2split[0]. "',103) 
                    AND CONVERT(DATE,'" .$week2split[1]. "',103)
                    AND STATUS_ADV ='A'
                    AND ACTIVESTATUS ='1'
                    AND EMPLOYEECODE ='".$result_seData['EMPLOYEECODE']."' ";
        $query_seDay2 = sqlsrv_query($conn, $sql_seDay2, $params_seDay2);
        $result_seDay2 = sqlsrv_fetch_array($query_seDay2, SQLSRV_FETCH_ASSOC);
    }else{
        
    }
    
    // หาข้อมูล WEEK3   
    if ($_GET['dateweek3'] != '') {
        $sql_seDay3 = "SELECT CLASHID,EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV
                    FROM [dbo].[CLASHADVANCE]
                    WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,'" .$week3split[0]. "',103) 
                    AND CONVERT(DATE,'" .$week3split[1]. "',103)
                    AND STATUS_ADV ='A'
                    AND ACTIVESTATUS ='1'
                        AND EMPLOYEECODE ='".$result_seData['EMPLOYEECODE']."' ";
        $query_seDay3 = sqlsrv_query($conn, $sql_seDay3, $params_seDay3);
        $result_seDay3 = sqlsrv_fetch_array($query_seDay3, SQLSRV_FETCH_ASSOC);
    }else{
       
    }
    
    // หาข้อมูล WEEK4 
    if ($_GET['dateweek4'] != '') {
        $sql_seDay4 = "SELECT CLASHID,EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV
                    FROM [dbo].[CLASHADVANCE]
                    WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,'" .$week4split[0]. "',103) 
                    AND CONVERT(DATE,'" .$week4split[1]. "',103)
                    AND STATUS_ADV ='A'
                    AND ACTIVESTATUS ='1'
                    AND EMPLOYEECODE ='".$result_seData['EMPLOYEECODE']."' ";
        $query_seDay4 = sqlsrv_query($conn, $sql_seDay4, $params_seDay4);
        $result_seDay4 = sqlsrv_fetch_array($query_seDay4, SQLSRV_FETCH_ASSOC);
    }else{

    }
    
    // หาข้อมูล WEEK5 
    if ($_GET['dateweek5'] != '') {
        $sql_seDay5 = "SELECT CLASHID,EMPLOYEECODE,EMPLOYEENAME,PRICE,REASON,STATUS_ADV
                        FROM [dbo].[CLASHADVANCE]
                        WHERE  CONVERT(DATE,DATE_ADV) BETWEEN CONVERT(DATE,'" .$week5split[0]. "',103) 
                        AND CONVERT(DATE,'" .$week5split[1]. "',103)
                        AND STATUS_ADV ='A'
                        AND ACTIVESTATUS ='1'
                        AND EMPLOYEECODE ='".$result_seData['EMPLOYEECODE']."' ";
        $query_seDay5 = sqlsrv_query($conn, $sql_seDay5, $params_seDay5);
        $result_seDay5 = sqlsrv_fetch_array($query_seDay5, SQLSRV_FETCH_ASSOC);
    }else{

    }
    


    $allprice = $result_seDay1['PRICE'] + $result_seDay2['PRICE']+$result_seDay3['PRICE']+$result_seDay4['PRICE']+$result_seDay5['PRICE'];   

    $sql_sePosId = "SELECT PositionID AS 'POSID'  FROM  EMPLOYEEEHR2  WHERE PersonCode = '" . $result_seData['EMPLOYEECODE'] . "'";
    $query_sePosId = sqlsrv_query($conn, $sql_sePosId, $params_sePosId);
    $result_sePosId = sqlsrv_fetch_array($query_sePosId, SQLSRV_FETCH_ASSOC);

    $sql_sePosName = "SELECT PositionNameT AS 'POSNAME'  FROM POSITIONEHR WHERE PositionID ='" . $result_sePosId ['POSID'] . "'";
    $query_sePosName = sqlsrv_query($conn, $sql_sePosName, $params_sePosName);
    $result_sePosName = sqlsrv_fetch_array($query_sePosName, SQLSRV_FETCH_ASSOC);

    
    ?>
            <tr style="border:1px solid #000;" >
                <td style="border-right:1px solid #000;padding:3px;text-align:center;" ><?= $i ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" >&nbsp;<?= $result_seData['EMPLOYEECODE'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_seData['EMPLOYEENAME'] ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:left;" ><?= $result_sePosName['POSNAME'] ?></td>
                <!-- PRICE DAY1 -->
                <?php 
                if ($result_seDay1['PRICE'] == '0' || $result_seDay1['PRICE'] == '') {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" >-</td>
                <?php
                }else {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($result_seDay1['PRICE']) ?></td>
                <?php
                }
                ?>
                <!-- PRICE DAY2 -->
                <?php 
                if ($result_seDay2['PRICE'] == '0' || $result_seDay2['PRICE'] == '') {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" >-</td>
                <?php
                }else {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($result_seDay2['PRICE']) ?></td>
                <?php
                }
                ?>
                <!-- PRICE DAY3 -->
                <?php 
                if ($result_seDay3['PRICE'] == '0' || $result_seDay3['PRICE'] == '') {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" >-</td>
                <?php
                }else {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($result_seDay3['PRICE']) ?></td>
                <?php
                }
                ?>
                <!-- PRICE DAY4 -->
                <?php 
                if ($result_seDay4['PRICE'] == '0' || $result_seDay4['PRICE'] == '') {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" >-</td>
                <?php
                }else {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($result_seDay4['PRICE']) ?></td>
                <?php
                }
                ?>
                <!-- PRICE DAY5 -->
                <?php 
                if ($result_seDay5['PRICE'] == '0' || $result_seDay5['PRICE'] == '') {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" >-</td>
                <?php
                }else {
                ?>
                    <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($result_seDay5['PRICE']) ?></td>
                <?php
                }
                ?>
                <td style="border-right:1px solid #000;padding:3px;text-align:right;" ><?= number_format($allprice) ?></td>
                <td style="border-right:1px solid #000;padding:3px;text-align:right;" ></td>
            </tr>


    <?php
    $i++;   
    $priceday1 = $priceday1 + $result_seDay1['PRICE'];
    $priceday2 = $priceday2 + $result_seDay2['PRICE'];
    $priceday3 = $priceday3 + $result_seDay3['PRICE'];
    $priceday4 = $priceday4 + $result_seDay4['PRICE'];
    $priceday5 = $priceday5 + $result_seDay5['PRICE'];
    $allpricesum = $allpricesum + $allprice;
}
?>
</tbody>
<tfoot>
     <tr style="border:1px solid #000;background-color: #ccc">
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b>รวม</td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($priceday1)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($priceday2)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($priceday3)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($priceday4)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($priceday5)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b><?=number_format($allpricesum)?></td>
        <td   style="border-right:1px solid #000;padding:11px;text-align:right;"><b></td>
    </tr>
</tfoot>
<?php
if ($_GET['companycode'] == '04' || $_GET['companycode'] == '05' || $_GET['companycode'] == '09') {
?>
    <table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="">
        <td colspan="3" style="padding:4px;text-align:center;">
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </td>
        <td colspan="3"  style="padding:4px;text-align:center;">
          <br>
          <br>  
          ..............................................
          <br>
          (คุณอรัณย์ ศรีสุวรรณ)
          <br>
          ผู้อนุมัติ
          <br>
          ............./............../...........
          <br>
        </td>
        <td colspan="3"  style="padding:4px;text-align:center;">
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        </td>
    </tr>
    </tbody>

</table>
<?php
}else {
?>  
  <table width="100%" style="border-collapse: collapse;margin-top:8px;">
<tbody>
<tr style="">
        <td colspan="3" style="padding:4px;text-align:center;">
          <br>
          <br>
          ..............................................
          <br>
          (คุณนรินทร์ พิลึก)
          <br>
          ผู้ตรวจสอบ
          <br>
          ............./............../...........
          <br>
        </td>
        <td colspan="3"  style="padding:4px;text-align:center;">
          <br>
          <br>  
          ..............................................
          <br>
          (คุณอรัณย์ ศรีสุวรรณ)
          <br>
          ผู้อนุมัติ
          <br>
          ............./............../...........
          <br>
        </td>
        <td colspan="3"  style="padding:4px;text-align:center;">
          <br>
          <br>
          ..............................................
          <br>
          (คุณขวัญตา ศรีสุวรรณ)
          <br>
          ผู้อนุมัติจ่าย
          <br>
          ............./............../...........
          <br>
        </td>
    </tr>
    </tbody>

</table>  
<?php
}
?>

</table>
<!-- <br>
    <table>
    <b>*หมายเหตุ</b><br>
    <b>-ค่าความดัน</b><br>
    <b>&nbsp;&nbsp;-ค่าบน : 90-140</b><br>
    <b>&nbsp;&nbsp;-ค่าล่าง : 60-90</b><br>    
    <b>&nbsp;&nbsp;-อัตตราการเต้นของหัวใจ : 60-100 ครั้ง</b>  <br> 
    <b>-ค่าออกซิเจนในเลือด : 90-100%</b>  <br> 
    <b>-แอลกอฮอล์ :0 มิลลิกรัมเปอเซ็นต์</b>
</table> -->
    


<?php
sqlsrv_close($conn);
?>
