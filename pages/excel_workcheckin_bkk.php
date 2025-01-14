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

$strExcelFileName = "รายงานตัวปฎิบัติงาน" . $_GET['datestart'] . "ถึงวันที่" . $_GET['dateend'] . ".xls";
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

                    <th colspan="14" style="border-top:1px solid #000;font-size:14px;border:1px solid #000;padding:6px;text-align:center">
                        <b>รายงานตัวปฎิบัติงานประจำวันที่ <?= $_GET['datestart'] ?> ถึงวันที่ <?= $_GET['dateend'] ?></b> 

                    </th>

                </tr>
                <tr>

                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">ลำดับ</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">สายงาน</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">รหัสพนักงาน</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">ชื่อ-นามสกุล</th>
                                                                        
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">สาเหตุ</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">วันที่</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" rowspan="2" rowspan="2">เวลา (ช่วงเวลา)</th>
                                                                        <!--<th rowspan="2">ที่อยู่ (แผนที่)</th>
                                                                        <th rowspan="2">ที่อยู่ (ปัจจุบัน)</th>-->
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" colspan="3">ที่อยู่ (ปัจจุบัน)</th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center"><< ระยะห่าง (ก.ม) >></th>
                                                                        <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center" colspan="3">ที่อยู่ (แผนที่)</th>

                                                                    </tr>
                                                                     <tr>

                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ตำบล</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">อำเภอ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">จังหวัด</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">&nbsp;</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">ตำบล</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">อำเภอ</th>
                    <th bgcolor="#D9D9D9" style="border:1px solid #000;padding:4px;text-align: center">จังหวัด</th>

                </tr>
                                                                  
                
            </thead>
            <tbody>
                <?php
                $i = 1;
                $condWorkcheckin1 = " AND CONVERT(DATE,a.CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $condWorkcheckin2 = " AND c.DEPARTMENTCODE = '" . $_GET['department'] . "' AND c.[SECTIONCODE] = '" . $_GET['section'] . "'";
                if ($_GET['time'] == 'เช้า') {
                    $time = " AND CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) > '00:01' AND CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) < '11:59' ";
                } else if ($_GET['time'] == 'บ่าย') {
                    $time = " AND  CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) > '12:00' AND CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) < '17:59'";
                } else if ($_GET['time'] == 'เย็น') {
                    $time = " CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) > '18:00' AND CONVERT(NVARCHAR(5),CONVERT(TIME,a.CREATEDATE,103)) < '23:59'";
                } else {
                    $time = "";
                }
                $condCat = ($_GET['category'] != "") ? " AND b.PositionID ='" . $_GET['category'] . "'" : "";




              




                $sql_seWorkcheckin = "{call megWorkcheckin_v2(?,?,?,?)}";
                $params_seWorkcheckin = array(
                    array('select_workcheckin', SQLSRV_PARAM_IN),
                    array($condWorkcheckin2, SQLSRV_PARAM_IN),
                    array($condWorkcheckin1, SQLSRV_PARAM_IN),
                    array($time . $condCat." AND c.AREA = '".$_GET['area']."'", SQLSRV_PARAM_IN)
                );
                $query_seWorkcheckin = sqlsrv_query($conn, $sql_seWorkcheckin, $params_seWorkcheckin);
                while ($result_seWorkcheckin = sqlsrv_fetch_array($query_seWorkcheckin, SQLSRV_FETCH_ASSOC)) {
                    /*$sql_seAddress = "SELECT 
            CONCAT(CASE WHEN a.CurrentAddress = '-' THEN '' ELSE a.CurrentAddress END,
            CASE WHEN a.CurrentBuilding = '-' THEN '' ELSE a.CurrentBuilding END,
            CASE WHEN a.CurrentSoi = '-' THEN '' ELSE 'ซ.'+a.CurrentSoi END,
            CASE WHEN a.CurrentRoad = '-' THEN '' ELSE 'ถนน'+a.CurrentRoad END,
            CASE WHEN b.DistrictT = '-' THEN '' ELSE 'ต.'+b.DistrictT END,
            CASE WHEN c.[AmphurT] = '-' THEN '' ELSE 'อ.'+c.[AmphurT] END,
            CASE WHEN d.ProveNameT = '-' THEN '' ELSE 'จ.'+d.ProveNameT END,
            CASE WHEN a.CurrentPostID = '-' THEN '' ELSE a.CurrentPostID END) AS 'ADDRESS' 
            FROM [203.150.225.30].[TigerE-HR].[dbo].[PNT_Person] a
            INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_District] b ON a.CurrentDistric = b.[DistrictID]
            INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Amphur] c ON a.CurrentAmphur = c.[AmphurID]
            INNER JOIN [203.150.225.30].[TigerE-HR].[dbo].[PNM_Province] d ON a.CurrentProvince = d.[ProvID]
            WHERE a.[PersonCode] = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'";*/
                    
                    
                    
                    $sql_seWorkcheckintime = "SELECT COUNT(*) AS 'CHKTIME' FROM [dbo].[WORKCHECKIN]
                                                                            WHERE CONVERT(DATE,'" . $result_seWorkcheckin['CREATEDATE1'] . "',103) = CONVERT(DATE,CREATEDATE)
                                                                            AND WORKCHECKINID = '" . $result_seWorkcheckin['WORKCHECKINID'] . "'
                                                                            AND
                                                                            (CONVERT(NVARCHAR,CONVERT(DATETIME,'" . $result_seWorkcheckin['CREATEDATE1'] . "'),108) BETWEEN CONVERT(DATETIME,'13:00:00',108) AND CONVERT(DATETIME,'14:00:00',108))";
            $params_seWorkcheckintime = array(
                array('select_workcheckin', SQLSRV_PARAM_IN),
                array($_GET['datestart'], SQLSRV_PARAM_IN)
            );
            $query_seWorkcheckintime = sqlsrv_query($conn, $sql_seWorkcheckintime, $params_seWorkcheckintime);
            $result_seWorkcheckintime = sqlsrv_fetch_array($query_seWorkcheckintime, SQLSRV_FETCH_ASSOC);
            $chkcolor = ($result_seWorkcheckintime['CHKTIME'] == '0') ? " style='color: red' " : "";
            
            
            
            
            
            $sql_seAddress = "SELECT[EMPLOYEECODEMASTER],[LATIUDEMASTER],[LONGITUDEMASTER],[MAPADDRESSMASTER],RIGHT(MAPADDRESSMASTER,1) AS 'CHKEN' FROM [dbo].[WORKCHECKINMASTER] WHERE [EMPLOYEECODEMASTER] = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'";
            $query_seAddress = sqlsrv_query($conn, $sql_seAddress, $params_seAddress);
            $result_seAddress = sqlsrv_fetch_array($query_seAddress, SQLSRV_FETCH_ASSOC);
            if(preg_match('/^[a-z]+$/i',$result_seAddress['CHKEN'])){ 
                $sql_seTambonmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',','))-3";
        $query_seTambonmaster = sqlsrv_query($conn, $sql_seTambonmaster, $params_seTambonmaster);
            $result_seTambonmaster = sqlsrv_fetch_array($query_seTambonmaster, SQLSRV_FETCH_ASSOC);
            $rsTambonmaster = $result_seTambonmaster['VALUE'];
                                                                           
	$sql_seAmphurmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',','))-2";
$query_seAmphurmaster = sqlsrv_query($conn, $sql_seAmphurmaster, $params_seAmphurmaster);
            $result_seAmphurmaster = sqlsrv_fetch_array($query_seAmphurmaster, SQLSRV_FETCH_ASSOC);
            
            $rsAmphurmaster = $result_seAmphurmaster['VALUE'];
                                                                                                                                                                                                       
	$sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',','))-1";
        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
            $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
            $rsProvincemaster = $result_seProvincemaster['VALUE'];
            }
            else
            {
                $sql_seTambonmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' '))-4";
        $query_seTambonmaster = sqlsrv_query($conn, $sql_seTambonmaster, $params_seTambonmaster);
            $result_seTambonmaster = sqlsrv_fetch_array($query_seTambonmaster, SQLSRV_FETCH_ASSOC);
$rsTambonmaster = $result_seTambonmaster['VALUE'];
	$sql_seAmphurmaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' '))-3";
$query_seAmphurmaster = sqlsrv_query($conn, $sql_seAmphurmaster, $params_seAmphurmaster);
            $result_seAmphurmaster = sqlsrv_fetch_array($query_seAmphurmaster, SQLSRV_FETCH_ASSOC);
            $rsAmphurmaster = $result_seAmphurmaster['VALUE'];
	$sql_seProvincemaster = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seAddress['MAPADDRESSMASTER']."',' '))-2";
        $query_seProvincemaster = sqlsrv_query($conn, $sql_seProvincemaster, $params_seProvincemaster);
            $result_seProvincemaster = sqlsrv_fetch_array($query_seProvincemaster, SQLSRV_FETCH_ASSOC);
            $rsProvincemaster = $result_seProvincemaster['VALUE'];
            }
            
               
         
if(preg_match('/^[a-z]+$/i',$result_seWorkcheckin['CHKEN'])){ 
     $sql_seTambon = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',','))-3";
        $query_seTambon = sqlsrv_query($conn, $sql_seTambon, $params_seTambon);
            $result_seTambon = sqlsrv_fetch_array($query_seTambon, SQLSRV_FETCH_ASSOC);
            $rsTambon = $result_seTambon['VALUE'];
            
               
            $sql_seAmphur = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',','))-2";
$query_seAmphur = sqlsrv_query($conn, $sql_seAmphur, $params_seAmphur);
 $result_seAmphur = sqlsrv_fetch_array($query_seAmphur, SQLSRV_FETCH_ASSOC);
$rsAmphur = $result_seAmphur['VALUE'];



	$sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',',')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',','))-1";
        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
            $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
            $rsProvince = $result_seProvince['VALUE'];
}else{
	$sql_seTambon = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' '))-4";
        $query_seTambon = sqlsrv_query($conn, $sql_seTambon, $params_seTambon);
            $result_seTambon = sqlsrv_fetch_array($query_seTambon, SQLSRV_FETCH_ASSOC);
            $rsTambon = $result_seTambon['VALUE'];
            
            
            $sql_seAmphur = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' '))-3";
$query_seAmphur = sqlsrv_query($conn, $sql_seAmphur, $params_seAmphur);
 $result_seAmphur = sqlsrv_fetch_array($query_seAmphur, SQLSRV_FETCH_ASSOC);
$rsAmphur = $result_seAmphur['VALUE'];



	$sql_seProvince = "SELECT VALUE FROM (
    SELECT
        ROW_NUMBER () OVER ( 
            ORDER BY (SELECT 1)
        ) RowNum,VALUE
    FROM 
        STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' ')
) t
WHERE 
    RowNum = (SELECT COUNT(*) FROM STRING_SPLIT('".$result_seWorkcheckin['MAPADDRESS']."',' '))-2";
        $query_seProvince = sqlsrv_query($conn, $sql_seProvince, $params_seProvince);
            $result_seProvince = sqlsrv_fetch_array($query_seProvince, SQLSRV_FETCH_ASSOC);
            $rsProvince = $result_seProvince['VALUE'];
}

                
   $chkcolort = ($result_seTambonmaster['VALUE'] == $result_seTambon['VALUE']) ? " style='color: green' " : " style='color: #ffd500'";  
   $chkcolora = ($result_seAmphurmaster['VALUE'] == $result_seAmphur['VALUE']) ? " style='color: green' " : " style='color: #ff9c00'";
   $chkcolorp = ($result_seProvincemaster['VALUE'] == $result_seProvince['VALUE']) ? " style='color: green' " : " style='color: #ff5c00'";
   
   
   
                       $sql_seCat = "SELECT b.PositionNameT FROM [RTMS].[dbo].[EMPLOYEEEHR] a INNER JOIN [dbo].[POSITIONEHR] b ON a.PositionID = b.PositionID WHERE a.PersonCode = '" . $result_seWorkcheckin['EMPLOYEECODE'] . "'";

                $query_seCat = sqlsrv_query($conn, $sql_seCat, $params_seCat);
                $result_seCat = sqlsrv_fetch_array($query_seCat, SQLSRV_FETCH_ASSOC);
                    ?>
                    <tr>
                        <tr <?=$chkcolor?>>
                                                                                                                                                                                                                    <td style="text-align:center;" ><?= $i ?></td>
                                                                                                                                                                                                        
                                                                                                                                                                                                        <td ><?= $result_seCat['PositionNameT'] ?></td>
                                                                                                                                                                                                                    <td ><?= $result_seWorkcheckin['EMPLOYEECODE'] ?></td>
                                                                                                                                                                                                                    <td ><?= $result_seWorkcheckin['FLNAME'] ?> (<?= $result_seWorkcheckin['CurrentTel'] ?>)</td>
                                                                                                                                                                                                        <td ><?= $result_seWorkcheckin['BEFOREACTIVITY'] ?></td>
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                                    <td ><?= $result_seWorkcheckin['CREATEDATE'] ?></td>
                                                                                                                                                                                                                    <td ><?= $result_seWorkcheckin['CREATETIME'] ?> <u>(<?= $result_seWorkcheckin['CREATETIME1'] ?>)</u></td>
                                                                                                                                                                                                                    <!--<td ><?//= $result_seWorkcheckin['MAPADDRESS'] ?></td>
                                                                                                                                                                                                                    <td ><?//= $result_seAddress['MAPADDRESSMASTER'] ?></td>-->
                                                                                                                                                                                                          <td <?=$chkcolort?>><?=$rsTambonmaster?></td>
                                                                                                                                                                                                        <td <?=$chkcolora?>><?=$rsAmphurmaster?></td>
                                                                                                                                                                                                        <td <?=$chkcolorp?>><?=$rsProvincemaster?></td>
                                                                                                                                                                                                         <td style="text-align:center;"><?= haversineGreatCircleDistance($result_seAddress['LATIUDEMASTER'],$result_seAddress['LONGITUDEMASTER'],$result_seWorkcheckin['LATIUDE'],$result_seWorkcheckin['LONGITUDE'])?></td>
                                                                                                                                                                                                        <td <?=$chkcolort?>><?=$rsTambon?></td>
                                                                                                                                                                                                        <td <?=$chkcolora?>><?=$rsAmphur?></td>
                                                                                                                                                                                                        <td <?=$chkcolorp?>><?=$rsProvince?></td>

                    </tr>
                    <?php
                     $rs = $rs.str_replace(',', "','", $emp.','.$result_seWorkcheckin['EMPLOYEECODE']);
           $i++;
                }
                ?>
<?php
             
            
            //echo );
            
           
            
        
       $y = $i;
        $sql_seEmployeenotcheckin = "SELECT a.CurrentTel,a.PersonCode,a.FnameT+' '+a.LnameT AS 'FLnameT' FROM [dbo].[EMPLOYEEEHR] a
        INNER JOIN [dbo].[ORGANIZATION] b ON a.PersonCode = b.EMPLOYEECODE
        WHERE 1=1
        AND a.PersonCode NOT IN('".substr($rs,3,strlen($rs))."')
        AND b.AREA = '".$_GET['area']."' AND b.DEPARTMENTCODE = '" . $_GET['department'] . "' AND b.[SECTIONCODE] = '".$_GET['section']."' AND b.DEPARTMENTCODE !='' AND b.[SECTIONCODE] !=''";

            $query_seEmployeenotcheckin = sqlsrv_query($conn, $sql_seEmployeenotcheckin, $params_seEmployeenotcheckin);
            while($result_seEmployeenotcheckin = sqlsrv_fetch_array($query_seEmployeenotcheckin, SQLSRV_FETCH_ASSOC)){
        ?>
                                                    <tr style='color: #CCCCCC'>
                                                                <td style="text-align:center;" ><?= $y ?></td>
                                                                <td >-</td>
                                                                <td ><?= $result_seEmployeenotcheckin['PersonCode'] ?></td>
                                                                <td ><?= $result_seEmployeenotcheckin['FLnameT'] ?> (<?= $result_seWorkcheckin['CurrentTel'] ?>)</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                <td >-</td>
                                                                 
                                                               
                                                                <!--<td style="text-align: center"><a href="#" data-toggle="modal" onclick="send_data('<?//=$result_seWorkcheckin['EMPLOYEECODE']?>','<?//=$result_seWorkcheckin['FLNAME']?>','<?//=$result_seWorkcheckin['CREATEDATE']?>','<?//=$result_seWorkcheckin['CREATETIME']?>','<?//=$result_seWorkcheckin['LATIUDE']?>','<?//=$result_seWorkcheckin['LONGITUDE']?>')"  data-target="#modal_selectline" class="btn btn-success"><b>@LINE</b></a></td>-->
                                                                <td style="text-align: center">-</td>
                                                                <td style="text-align: center;">-</td>



                                                                </tr>
                                                                <?php
                                                                $y++;
            }
            ?>

            </tbody>

        </table>
    </body>
</html>
