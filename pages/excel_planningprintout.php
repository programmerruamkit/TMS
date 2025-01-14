<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
error_reporting(E_ERROR | E_PARSE);
$conn = connect("RTMS");


$strExcelFileName = "ข้อมูลแผนงาน สายงาน " . $_GET['customercode'] . "_" . $_GET['datestartplan'] . "ถึง" . $_GET['dateendplan'] . ".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="'.$strExcelFileName);
header("Content-Type: application/force-download"); 
header("Content-Type: application/octet-stream"); 
header("Content-Type: application/download"); 
header("Content-Transfer-Encoding: binary"); 
@readfile($strExcelFileName);  

// header("Content-Length: ".filesize("myexcel.xls"));   



// $strExcelFileName = "รายการค่าอาหารประจำวันที่" . $_GET['datestart'] . "ถึงวันที่" . $_GET['dateend'] . ".xls";
// header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
// header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
// header("Pragma:no-cache");

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table style="" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" >
            <thead>
                <tr>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ลำดับ</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">รอบวิ่ง</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ชื่อรถ</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">พนักงาน(1)</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">พนักงาน(2)</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">รายงานตัว</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ต้นทาง</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">คลัสเตอร์</td>
                    <?php
                    if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {
                        ?>
                        <th bgcolor="#D9D9D9" style="text-align: center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ภาค</th>
                        <?php
                    } else {
                        ?>
                        
                        <?php
                    }
                    ?>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ปลายทาง</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">หมายเลขงาน</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ทำแผน</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ทำงาน</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">เข้า(ลูกค้า)</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">ออก(ลูกค้า)</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">เข้า(ลูกค้า2)</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">กลับบริษัท</td>
                    <td bgcolor="#D9D9D9" style="text-align:center;padding:4px;border-right: 1px solid #000000;border-bottom: 1px solid #000000;font-size: 18px;">สถานะ</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;

                $sql_sePlanningData = "SELECT b.CARRYTYPE,b.WORKTYPE,a.ROUNDAMOUNT,a.VEHICLETRANSPORTPLANID,a.VEHICLETYPE, a.CUSTOMERCODE, a.COMPANYCODE, 
                    a.VEHICLEREGISNUMBER1, a.VEHICLEREGISNUMBER2,a.THAINAME,a.THAINAME2,a.ENGNAME, a.VEHICLETRANSPORTPRICEID, 
                    a.CLUSTER, a.JOBSTART, a.JOBEND, 
                    a.EMPLOYEECODE1,a.EMPLOYEENAME1, a.EMPLOYEECODE2,a.EMPLOYEENAME2, a.EMPLOYEECODE3,
                    a.EMPLOYEENAME3, a.EMPLOYEECODE4,a.EMPLOYEENAME4,a.EMPLOYEECODECONTROL,a.EMPLOYEENAMECONTROL, a.JOBNO, a.DOCUMENTCODE,a.ACTUALPRICE,
                    CONVERT(VARCHAR(10), a.DATEINPUT, 103) + ' '  + convert(VARCHAR(8), a.DATEINPUT, 14) AS 'DATEINPUT', 
                    CONVERT(VARCHAR(10), a.DATEWORKING, 103) + ' '  + convert(VARCHAR(5), a.DATEWORKING, 14) AS 'DATEWORKING', 
                    CONVERT(VARCHAR(10), a.DATEWORKSUS, 103) + ' '  + convert(VARCHAR(8), a.DATEWORKSUS, 14) AS 'DATEWORKSUS', 
                    CONVERT(VARCHAR(10), a.DATEPRESENT, 103) + ' '  + convert(VARCHAR(8), a.DATEPRESENT, 14) AS 'DATEPRESENT', 
                    CONVERT(VARCHAR(10), a.DATERK, 103) + ' '  + convert(VARCHAR(8), a.DATERK, 14) AS 'DATERK',

                    CONVERT(VARCHAR(10), a.DATEVLIN, 103) + ' '  + convert(VARCHAR(8), a.DATEVLIN, 14) AS 'DATEVLIN', 
                    CONVERT(VARCHAR(10), a.DATEVLOUT, 103) + ' '  + convert(VARCHAR(8), a.DATEVLOUT, 14) AS 'DATEVLOUT', 
                    CONVERT(VARCHAR(10), a.DATEDEALERIN, 103) + ' '  + convert(VARCHAR(8), a.DATEDEALERIN, 14) AS 'DATEDEALERIN', 
                    CONVERT(VARCHAR(10), a.DATERETURN, 103) + ' '  + convert(VARCHAR(8), a.DATERETURN, 14) AS 'DATERETURN',
                    a.[STATUS],a.STATUSNUMBER
                    FROM dbo.VEHICLETRANSPORTPLAN a
                    LEFT  JOIN [dbo].[VEHICLETRANSPORTPRICE] b ON a.[VEHICLETRANSPORTPRICEID] = b.[VEHICLETRANSPORTPRICEID] 
                    WHERE a.ACTIVESTATUS = '1' AND a.STATUSNUMBER != '0'
                    AND a.COMPANYCODE ='".$_GET['companycode']."' AND a.CUSTOMERCODE ='".$_GET['customercode']."'
                    AND (a.WORKTYPE = '' OR a.WORKTYPE IS NULL) AND (b.CARRYTYPE = 'trip' OR b.CARRYTYPE IS NULL)
                    AND (CONVERT(DATE,a.DATEWORKING,103) BETWEEN CONVERT(DATE,'".$_GET['datestartplan']."',103) AND CONVERT(DATE,'".$_GET['dateendplan']."',103))
                    ORDER BY a.DATERK,a.EMPLOYEECODE1,a.ROUNDAMOUNT ASC";
                $params_sePlanningData = array();
                $query_sePlanningData = sqlsrv_query($conn, $sql_sePlanningData, $params_sePlanningData);
                while ($result_sePlanningData = sqlsrv_fetch_array($query_sePlanningData, SQLSRV_FETCH_ASSOC)) {

                     if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {

                        $sql_seConfrimskb = "SELECT JOBEND = STUFF((
                            SELECT ', ' + JOBEND
                            FROM dbo.CONFRIMSKB
                            WHERE VEHICLETRANSPORTPLANID = '" . $result_sePlanningData['VEHICLETRANSPORTPLANID'] . "'
                            FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, ''),
                            CLUSTER = STUFF((
                            SELECT DISTINCT ', ' + CLUSTER
                            FROM dbo.CONFRIMSKB
                            WHERE VEHICLETRANSPORTPLANID = '" . $result_sePlanningData['VEHICLETRANSPORTPLANID'] . "'
                            FOR XML PATH(''), TYPE).value('.', 'VARCHAR(MAX)'), 1, 2, '') ";
                        $query_seConfrimskb = sqlsrv_query($conn, $sql_seConfrimskb, $params_seConfrimskb);
                        $result_seConfrimskb = sqlsrv_fetch_array($query_seConfrimskb, SQLSRV_FETCH_ASSOC);
                            
                        // echo $result_seConfrimskb['CLUSTER'];
                        $VAR_JOBEND = ($result_sePlanningData['CUSTOMERCODE'] == 'SKB') ? $result_seConfrimskb['JOBEND'] : $result_sePlanningData['JOBEND'];
                        $VAR_CLUSTER = ($result_sePlanningData['CUSTOMERCODE'] == 'SKB') ? $result_seConfrimskb['CLUSTER'] : $result_sePlanningData['CLUSTER'];
                        
                       
                        
                        $clusterplit = explode(",", $VAR_CLUSTER);
                        
                        // echo $VAR_CLUSTER;
                        // echo($clusterplit[0]);
                        // echo "</br>";
                        // echo($clusterplit[1]);
                        // echo "</br>";
                        // echo($clusterplit[2]);
                    
                        $sql_seZoneSKB1 = "SELECT ZONE AS 'ZONE1' FROM ZONEFORSKB 
                                        WHERE PROVINCE ='".$clusterplit[0]."'";
                        $params_seZoneSKB1 = array();
                        $query_seZoneSKB1  = sqlsrv_query($conn, $sql_seZoneSKB1, $params_seZoneSKB1);
                        $result_seZoneSKB1 = sqlsrv_fetch_array($query_seZoneSKB1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_seZoneSKB2 = "SELECT ZONE AS 'ZONE2' FROM ZONEFORSKB 
                                        WHERE PROVINCE ='".$clusterplit[1]."'";
                        $params_seZoneSKB2 = array();
                        $query_seZoneSKB2  = sqlsrv_query($conn, $sql_seZoneSKB2, $params_seZoneSKB2);
                        $result_seZoneSKB2 = sqlsrv_fetch_array($query_seZoneSKB2, SQLSRV_FETCH_ASSOC);

                        $sql_seZoneSKB3 = "SELECT ZONE AS 'ZONE3' FROM ZONEFORSKB 
                                        WHERE PROVINCE ='".$clusterplit[2]."'";
                        $params_seZoneSKB3 = array();
                        $query_seZoneSKB3  = sqlsrv_query($conn, $sql_seZoneSKB3, $params_seZoneSKB3);
                        $result_seZoneSKB3 = sqlsrv_fetch_array($query_seZoneSKB3, SQLSRV_FETCH_ASSOC);
                        
                        //เช็ค Zone ตำแหน่งที่1 ที่ซ้ำกัน
                        if ( ($result_seZoneSKB1['ZONE1'] == $result_seZoneSKB2['ZONE2'])   ) {
                            $zone1 = $result_seZoneSKB1['ZONE1'] ;
                        }else if(($result_seZoneSKB1['ZONE1'] == $result_seZoneSKB3['ZONE3'])) {
                            $zone1 = $result_seZoneSKB1['ZONE1'] ;
                        }else{
                            $zone1 = $result_seZoneSKB1['ZONE1'];
                        } 

                        //เช็ค Zone ตำแหน่งที่1 ที่ซ้ำกัน
                        if ( ($result_seZoneSKB2['ZONE2'] == $result_seZoneSKB1['ZONE1'])) {
                            $zone2 = '' ;
                        }else if($result_seZoneSKB2['ZONE2'] == $result_seZoneSKB3['ZONE3']){
                            $zone2 = $result_seZoneSKB2['ZONE2'] ;
                        }else {
                            $zone2 = $result_seZoneSKB2['ZONE2'];
                        } 

                        //เช็ค Zone ตำแหน่งที่1 ที่ซ้ำกัน
                        if ( ($result_seZoneSKB3['ZONE3'] == $result_seZoneSKB1['ZONE1'])) {
                            $zone3 = '' ;
                        }else if($result_seZoneSKB3['ZONE3'] == $result_seZoneSKB2['ZONE2']){
                            $zone3 = '' ;
                        }else {
                            $zone3 = $result_seZoneSKB3['ZONE3'];
                        } 

                     }else {
                        # code...
                         // echo $result_seConfrimskb['CLUSTER'];
                         $VAR_JOBEND    =  $result_sePlanningData['JOBEND'];
                         $VAR_CLUSTER   = $result_sePlanningData['CLUSTER'];
                         
                     }
                       
                    ?>
                    <tr>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $i ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['ROUNDAMOUNT'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['THAINAME'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['EMPLOYEENAME1'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['EMPLOYEENAME2'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATEPRESENT'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['JOBSTART'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $VAR_CLUSTER ?></td>
                        <?php
                        if ($_GET['companycode'] == 'RKL' && $_GET['customercode'] == 'SKB') {
                            ?>
                            <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $zone1 ?>,<?= $zone2 ?>,<?= $zone3 ?></td>
                            <?php
                        } else {
                            ?>
                            
                            <?php
                        }
                        ?>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $VAR_JOBEND ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['JOBNO'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATEINPUT'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATERK'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATEVLIN'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATEVLOUT'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATEDEALERIN'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['DATERETURN'] ?></td>
                        <td style="text-align:left;padding:4px;border-bottom: 1px solid #000000;;border-right: 1px solid #000000"><?= $result_sePlanningData['STATUS'] ?></td>
                    </tr>
    <?php
    $i++;
}
?>

            </tbody>
        </table>
    </body>
</html>
