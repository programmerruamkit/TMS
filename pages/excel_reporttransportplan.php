<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $strExcelFileName = "รายงานแผนการขนส่ง.xls";
} else {
    $strExcelFileName = "รายงานแผนการขนส่งตั้งแต่วันที่" . $_GET['datestart'] . ' ถึง ' . $_GET['dateend'] . ".xls";
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
?>
<html>
    <head>
        <link rel="shortcut icon" href="../images/logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <th><label style="width: 50px">NO(ลำดับ)</label></th>
                    <th><label style="width: 200px">CUSTOMERCODE(ลูกค้า)</label></th>
                    <th><label style="width: 200px">COMPANYCODE(บริษัท)</label></th>
                    <th><label style="width: 200px">VEHICLETYPE(ประเภทรถ)</label></th>
                    <th><label style="width: 200px">VEHICLEREGISNUMBER1(ทะเบียน1)</label></th>
                    <th><label style="width: 200px">VEHICLEREGISNUMBER2(ทะเบียน2)</label></th>
                    <th><label style="width: 200px">ชื่อรถ(ไทย)</label></th>
                    <th><label style="width: 200px">ชื่อรถ(อังกฤษ)</label></th>
                    <th><label style="width: 200px">เลขที่อ้างอิงราคาขนส่ง</label></th>
                    <th><label style="width: 200px">CLUSTER(ชื่อคัทเตอร์)</label></th>
                    <th><label style="width: 200px">CLUSTER_TH(ชื่อคัทเตอร์ไทย)</label></th>
                    <th><label style="width: 200px">DEALERCODE(ชื่อดีลเลอร์)</label></th>
                    <th><label style="width: 200px">NAME(ชื่องาน)</label></th>
                    <th><label style="width: 200px">VEHICLEAMOUNT(จำนวนโหลด)</label></th>
                    <th><label style="width: 200px">SRBASE4L(ราคาสำโรง 4 โหลด)</label></th>
                    <th><label style="width: 200px">SRBASE8L(ราคาสำโรง 8 โหลด)</label></th>
                    <th><label style="width: 200px">GWBASE4L(ราคาเกตุเวย์ 4 โหลด)</label></th>
                    <th><label style="width: 200px">GWBASE8L(ราคาเกตุเวย์ 8 โหลด)</label></th>
                    <th><label style="width: 200px">BPBASE4L(ราคาบ้านโพธิ์ 4 โหลด)</label></th>
                    <th><label style="width: 200px">BPBASE8L(ราคาบ้านโพธิ์ 8 โหลด)</label></th>
                    <th><label style="width: 200px">TACBASE4L(ราคาสำโรง 4 โหลด)</label></th>
                    <th><label style="width: 200px">TACBASE8L(ราคาสำโรง 4 โหลด)</label></th>
                    <th><label style="width: 200px">OTHBASE4L(ราคาสำโรง 4 โหลด)</label></th>
                    <th><label style="width: 200px">OTHBASE8L(ราคาสำโรง 4 โหลด)</label></th>
                    <th><label style="width: 200px">ACTUALPRICE(ราคาขนส่ง)</label></th>
                    <th><label style="width: 200px">E1(ค่าเที่ยวข้อมูลดิบ)</label></th>
                    <th><label style="width: 200px">E2(ค่าเที่ยวข้อมูลสารสนเทศ)</label></th>
                    <th><label style="width: 200px">JOBSTART(ต้นทาง)</label></th>
                    <th><label style="width: 200px">JOBEND(ปลายทาง)</label></th>
                    <th><label style="width: 200px">EMPLOYEECODE1(รหัสพนักงาน1)</label></th>
                    <th><label style="width: 200px">EMPLOYEENAME1(ชื่อพนักงาน1)</label></th>
                    <th><label style="width: 200px">EMPLOYEECODE2(รหัสพนักงาน2)</label></th>
                    <th><label style="width: 200px">EMPLOYEENAME2(ชื่อพนักงาน2)</label></th>
                    <th><label style="width: 200px">EMPLOYEECODE3(รหัสพนักงาน3)</label></th>
                    <th><label style="width: 200px">EMPLOYEENAME3(ชื่อพนักงาน3)</label></th>
                    <th><label style="width: 200px">EMPLOYEECODE4(รหัสพนักงาน4)</label></th>
                    <th><label style="width: 200px">EMPLOYEENAME4(ชื่อพนักงาน4)</label></th>
                    <th><label style="width: 200px">JOBNO(เลขที่งาน)</label></th>
                    <th><label style="width: 200px">DOCUMENTCODE(เลขที่เอกสาร)</label></th>
                    <th><label style="width: 200px">DATEWORKING(วันที่/เวลา ทำงาน)</label></th>
                    <th><label style="width: 200px">DATEPRESENT(วันที่/เวลา รายงานตัว)</label></th>
                    <th><label style="width: 200px">DATERK(วันที่/เวลา ร่วมกิจ)</label></th>
                    <th><label style="width: 200px">DATEVLIN(วันที่/เวลา เข้าวีแอล)</label></th>
                    <th><label style="width: 200px">DATEVLOUT(วันที่/เวลา ออกวีแอล)</label></th>
                    <th><label style="width: 200px">DATEDEALERIN(วันที่/เวลา เข้าดีลเลอร์)</label></th>
                    <th><label style="width: 200px">DATERETURN(วันที่/เวลา กลับบริษัท)</label></th>
                    <th><label style="width: 200px">DATEWORKSUS(วันที่/เวลา ทำงานเสร็จ)</label></th>
                    <th><label style="width: 200px">DATECLOSE(วันที่/เวลา ปิดงาน)</label></th>


                    <th><label style="width: 200px">MATERIALTYPE(ประเภทวัสดุ)</label></th>
                    <th><label style="width: 200px">WORKTYPE(ประเภทงาน)</label></th>
                    <th><label style="width: 200px">ACTIVESTATUS(สถานะ)</label></th>
                    <th><label style="width: 200px">REMARK(หมายเหตุ)</label></th>
                    <th><label style="width: 200px">ROUNDAMOUNT(รอบวิ่ง)</label></th>
                    <th><label style="width: 200px">เลขไมล์ต้น</label></th>
                    <th><label style="width: 200px">เลขไมล์ปลาย</label></th>


                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $condiReporttransport1 = " AND CONVERT(DATE,DATEVLIN) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103)";
                $condiReporttransport2 = " AND COMPANYCODE = '" . $_GET['companycode'] . "' AND CUSTOMERCODE = '" . $_GET['customercode'] . "' ORDER BY CONVERT(DATE,DATEWORKING,103) ASC";
                $condiReporttransport3 = "";

                $query_seReporttransport = sqlsrv_query($conn, "SELECT [VEHICLETRANSPORTPLANID]
                ,[CUSTOMERCODE]
                ,[COMPANYCODE]
                ,[VEHICLETYPE]
                ,[VEHICLEREGISNUMBER1]
                ,[VEHICLEREGISNUMBER2]
                
                ,[THAINAME]
                ,[ENGNAME]
                ,[VEHICLETRANSPORTPRICEID]
                ,[CLUSTER]
                ,[CLUSTER_TH]
                
                ,[DEALERCODE]
                ,[NAME]
                ,[VEHICLEAMOUNT]
                ,[SRBASE4L]
                ,[SRBASE8L]
                
                ,[GWBASE4L]
                ,[GWBASE8L]
                ,[BPBASE4L]
                ,[BPBASE8L]
                ,[TACBASE4L]
                
                ,[TACBASE8L]
                ,[OTHBASE4L]
                ,[OTHBASE8L]
                ,[ACTUALPRICE]
                ,[E1]
                
                ,[E2]
                ,[JOBSTART]
                ,[JOBEND]
                ,[EMPLOYEECODE1]
                ,[EMPLOYEENAME1]
                
                ,[EMPLOYEECODE2]
                ,[EMPLOYEENAME2]
                ,[EMPLOYEECODE3]
                ,[EMPLOYEENAME3]
                ,[EMPLOYEECODE4]
                
                ,[EMPLOYEENAME4]
                ,[JOBNO]
                ,[DOCUMENTCODE]
                ,CONVERT(VARCHAR(10), DATEWORKING, 103) + ' '  + convert(VARCHAR(8), DATEWORKING, 14) AS 'DATEWORKING'
                ,CONVERT(VARCHAR(10), DATEPRESENT, 103) + ' '  + convert(VARCHAR(8), DATEPRESENT, 14) AS 'DATEPRESENT'
                    
                ,CONVERT(VARCHAR(10), DATERK, 103) + ' '  + convert(VARCHAR(8), DATERK, 14) AS 'DATERK'
                ,CONVERT(VARCHAR(10), DATEVLIN, 103) + ' '  + convert(VARCHAR(8), DATEVLIN, 14) AS 'DATEVLIN'
                ,CONVERT(VARCHAR(10), DATEVLOUT, 103) + ' '  + convert(VARCHAR(8), DATEVLOUT, 14) AS 'DATEVLOUT'
                ,CONVERT(VARCHAR(10), DATEDEALERIN, 103) + ' '  + convert(VARCHAR(8), DATEDEALERIN, 14) AS 'DATEDEALERIN'
                ,CONVERT(VARCHAR(10), DATERETURN, 103) + ' '  + convert(VARCHAR(8), DATERETURN, 14) AS 'DATERETURN'
                    
                ,CONVERT(VARCHAR(10), DATEWORKSUS, 103) + ' '  + convert(VARCHAR(8), DATEWORKSUS, 14) AS 'DATEWORKSUS'
                ,CONVERT(VARCHAR(10), DATECLOSE, 103) + ' '  + convert(VARCHAR(8), DATECLOSE, 14) AS 'DATECLOSE'
                ,[MATERIALTYPE]
                ,[WORKTYPE]
                ,[ACTIVESTATUS]
                
                ,[REMARK]
                ,[ROUNDAMOUNT]
                FROM [RTMS].[dbo].[VEHICLETRANSPORTPLAN] WHERE 1=1 " . $condiReporttransport1 . $condiReporttransport2 . $condiReporttransport3, $params_seReporttransport);
                while ($result_seReporttransport = sqlsrv_fetch_array($query_seReporttransport, SQLSRV_FETCH_ASSOC)) {
                    
                    $sql_semileagestart = "SELECT TOP 1 MILEAGENUMBER  AS 'MILEAGESTART'
                        FROM MILEAGE  
                        WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
                        AND MILEAGETYPE ='MILEAGESTART' 
                        ORDER BY CREATEDATE DESC";
                    $params_semileagestart = array();
                    $query_semileagestart = sqlsrv_query($conn, $sql_semileagestart, $params_semileagestart);
                    $result_semileagestart = sqlsrv_fetch_array($query_semileagestart, SQLSRV_FETCH_ASSOC);

                    $sql_semileageend = "SELECT TOP 1 MILEAGENUMBER AS 'MILEAGEEND'
                        FROM MILEAGE  
                        WHERE JOBNO ='".$result_seReporttransport['JOBNO']."'
                        AND MILEAGETYPE ='MILEAGEEND' 
                        ORDER BY CREATEDATE DESC";
                    $params_semileageend = array();
                    $query_semileageend  = sqlsrv_query($conn, $sql_semileageend, $params_semileageend);
                    $result_semileageend = sqlsrv_fetch_array($query_semileageend, SQLSRV_FETCH_ASSOC);
                    
                    ?>

                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $result_seReporttransport['CUSTOMERCODE'] ?></td>
                        <td><?= $result_seReporttransport['COMPANYCODE'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLETYPE'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLEREGISNUMBER1'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLEREGISNUMBER2'] ?></td>
                        
                        <td><?= $result_seReporttransport['THAINAME'] ?></td>
                        <td><?= $result_seReporttransport['ENGNAME'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLETRANSPORTPRICEID'] ?></td>
                        <td><?= $result_seReporttransport['CLUSTER'] ?></td>
                        <td><?= $result_seReporttransport['CLUSTER_TH'] ?></td>
                        
                        <td><?= $result_seReporttransport['DEALERCODE'] ?></td>
                        <td><?= $result_seReporttransport['NAME'] ?></td>
                        <td><?= $result_seReporttransport['VEHICLEAMOUNT'] ?></td>
                        <td><?= $result_seReporttransport['SRBASE4L'] ?></td>
                        <td><?= $result_seReporttransport['SRBASE8L'] ?></td>
                        
                        <td><?= $result_seReporttransport['GWBASE4L'] ?></td>
                        <td><?= $result_seReporttransport['GWBASE8L'] ?></td>
                        <td><?= $result_seReporttransport['BPBASE4L'] ?></td>
                        <td><?= $result_seReporttransport['BPBASE8L'] ?></td>
                        <td><?= $result_seReporttransport['TACBASE4L'] ?></td>
                        
                        <td><?= $result_seReporttransport['TACBASE8L'] ?></td>
                        <td><?= $result_seReporttransport['OTHBASE4L'] ?></td>
                        <td><?= $result_seReporttransport['OTHBASE8L'] ?></td>
                        <td><?= $result_seReporttransport['ACTUALPRICE'] ?></td>
                        <td><?= $result_seReporttransport['E1'] ?></td>
                        
                        <td><?= $result_seReporttransport['E2'] ?></td>
                        <td><?= $result_seReporttransport['JOBSTART'] ?></td>
                        <td><?= $result_seReporttransport['JOBEND'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE1'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME1'] ?></td>
                        
                        <td><?= $result_seReporttransport['EMPLOYEECODE2'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME2'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE3'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEENAME3'] ?></td>
                        <td><?= $result_seReporttransport['EMPLOYEECODE4'] ?></td>
                        
                        <td><?= $result_seReporttransport['EMPLOYEENAME4'] ?></td>
                        <td><?= $result_seReporttransport['JOBNO'] ?></td>
                        <td><?= $result_seReporttransport['DOCUMENTCODE'] ?></td>
                        <td><?= $result_seReporttransport['DATEWORKING'] ?></td>
                        
                        <td><?= $result_seReporttransport['DATEPRESENT'] ?></td>
                        <td><?= $result_seReporttransport['DATERK'] ?></td>
                        <td><?= $result_seReporttransport['DATEVLIN'] ?></td>
                        <td><?= $result_seReporttransport['DATEVLOUT'] ?></td>
                        <td><?= $result_seReporttransport['DATEDEALERIN'] ?></td>
                        
                        <td><?= $result_seReporttransport['DATERETURN'] ?></td>
                        <td><?= $result_seReporttransport['DATEWORKSUS'] ?></td>
                        <td><?= $result_seReporttransport['DATECLOSE'] ?></td>
                        <td><?= $result_seReporttransport['MATERIALTYPE'] ?></td>
                        <td><?= $result_seReporttransport['WORKTYPE'] ?></td>
                        
                        <td><?= $result_seReporttransport['ACTIVESTATUS'] ?></td>
                        <td><?= $result_seReporttransport['REMARK'] ?></td>
                        <td><?= $result_seReporttransport['ROUNDAMOUNT'] ?></td>
                        <td><?= $result_semileagestart['MILEAGESTART'] ?></td>
                        <td><?= $result_semileageend['MILEAGEEND'] ?></td>


                    </tr>
                    <?php
                    $i++;
                }
                ?>




            </tbody>
        </table>
    </body>
</html>