<?php
ini_set('memory_limit', '140M');
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
ini_set('max_execution_time', 300);

$conn = connect("RTMS");
$condition2 = " AND Company_Code = '" . $_GET['companycode'] . "'";
$sql_seComp = "{call megCompany_v2(?,?)}";
$params_seComp = array(
    array('select_company', SQLSRV_PARAM_IN),
    array($condition2, SQLSRV_PARAM_IN)
);
$query_seComp = sqlsrv_query($conn, $sql_seComp, $params_seComp);
$result_seComp = sqlsrv_fetch_array($query_seComp, SQLSRV_FETCH_ASSOC);

$strExcelFileName = "รายงานค่าเที่ยวRRC(Detail)ประจำเดือน" . $_GET['datestart'] . ".xls";

header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<style>
    body{
        font-family: "Garuda";
    }
</style>

<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:12;">

    <thead>
        <tr style="border:1px solid #000;" >
            <td colspan="17" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สถานะรถซ่อม Update <?= $_GET['datestart'] ?>-<?= $_GET['dateend'] ?> Update Time : 17.00</b>
            </td>

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
           
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สายงาน</b>
            </td>
          
            <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>&nbsp;</b>
            </td>
            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สถานะปัจจุบัน</b>
            </td>
            <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การตรวจพบ</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td colspan="9" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>BM</b>
            </td>
            
            


        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>AMT</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อายุรถ</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อายุอะไหล่</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การใช้งานผิดประเภท</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ดำเนินการแล้ว</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ยังไม่ดำเนินการ</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ก่อน</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ขณะปฎิบัติงาน</b>
            </td>
            <td rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หลัง</b>
            </td>
        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ระบบไฟ</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ยางช่วงล่าง</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>โครงสร้าง</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เครื่องยนต์</b>
            </td>
            <td  style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อุปกรณ์ประจำรถ</b>
            </td>
        </tr>
        
        
        

    </thead><tbody>
        <?php
        $i = 1;

            
                        $sql_getRepairrks1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_REPAIRTYPE = 'ระบบไฟ'";
                        $params_getRepairrks1 = array();
                        $query_getRepairrks1 = sqlsrv_query($conn, $sql_getRepairrks1, $params_getRepairrks1);
                        $result_getRepairrks1 = sqlsrv_fetch_array($query_getRepairrks1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkr1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_REPAIRTYPE = 'ระบบไฟ'";
                        $params_getRepairrkr1 = array();
                        $query_getRepairrkr1 = sqlsrv_query($conn, $sql_getRepairrkr1, $params_getRepairrkr1);
                        $result_getRepairrkr1 = sqlsrv_fetch_array($query_getRepairrkr1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkl1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_REPAIRTYPE = 'ระบบไฟ'";
                        $params_getRepairrkl1 = array();
                        $query_getRepairrkl1 = sqlsrv_query($conn, $sql_getRepairrkl1, $params_getRepairrkl1);
                        $result_getRepairrkl1 = sqlsrv_fetch_array($query_getRepairrkl1, SQLSRV_FETCH_ASSOC);

                  
                        $sql_getRepairrks2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_REPAIRTYPE = 'ยางช่วงล่าง'";
                        $params_getRepairrks2 = array();
                        $query_getRepairrks2 = sqlsrv_query($conn, $sql_getRepairrks2, $params_getRepairrks2);
                        $result_getRepairrks2 = sqlsrv_fetch_array($query_getRepairrks2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkr2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_REPAIRTYPE = 'ยางช่วงล่าง'";
                        $params_getRepairrkr2 = array();
                        $query_getRepairrkr2 = sqlsrv_query($conn, $sql_getRepairrkr2, $params_getRepairrkr2);
                        $result_getRepairrkr2 = sqlsrv_fetch_array($query_getRepairrkr2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkl2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_REPAIRTYPE = 'ยางช่วงล่าง'";
                        $params_getRepairrkl2 = array();
                        $query_getRepairrkl2 = sqlsrv_query($conn, $sql_getRepairrkl2, $params_getRepairrkl2);
                        $result_getRepairrkl2 = sqlsrv_fetch_array($query_getRepairrkl2, SQLSRV_FETCH_ASSOC);
                  
                        $sql_getRepairrks3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_REPAIRTYPE = 'โครงสร้าง'";
                        $params_getRepairrks3 = array();
                        $query_getRepairrks3 = sqlsrv_query($conn, $sql_getRepairrks3, $params_getRepairrks3);
                        $result_getRepairrks3 = sqlsrv_fetch_array($query_getRepairrks3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkr3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_REPAIRTYPE = 'โครงสร้าง'";
                        $params_getRepairrkr3 = array();
                        $query_getRepairrkr3 = sqlsrv_query($conn, $sql_getRepairrkr3, $params_getRepairrkr3);
                        $result_getRepairrkr3 = sqlsrv_fetch_array($query_getRepairrkr3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkl3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_REPAIRTYPE = 'โครงสร้าง'";
                        $params_getRepairrkl3 = array();
                        $query_getRepairrkl3 = sqlsrv_query($conn, $sql_getRepairrkl3, $params_getRepairrkl3);
                        $result_getRepairrkl3 = sqlsrv_fetch_array($query_getRepairrkl3, SQLSRV_FETCH_ASSOC);
                   
                        $sql_getRepairrks4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_REPAIRTYPE = 'เครื่องยนต์'";
                        $params_getRepairrks4 = array();
                        $query_getRepairrks4 = sqlsrv_query($conn, $sql_getRepairrks4, $params_getRepairrks4);
                        $result_getRepairrks4 = sqlsrv_fetch_array($query_getRepairrks4, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkr4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_REPAIRTYPE = 'เครื่องยนต์'";
                        $params_getRepairrkr4 = array();
                        $query_getRepairrkr4 = sqlsrv_query($conn, $sql_getRepairrkr4, $params_getRepairrkr4);
                        $result_getRepairrkr4 = sqlsrv_fetch_array($query_getRepairrkr4, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkl4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_REPAIRTYPE = 'เครื่องยนต์'";
                        $params_getRepairrkl4 = array();
                        $query_getRepairrkl4 = sqlsrv_query($conn, $sql_getRepairrkl4, $params_getRepairrkl4);
                        $result_getRepairrkl4 = sqlsrv_fetch_array($query_getRepairrkl4, SQLSRV_FETCH_ASSOC);
                    
                        $sql_getRepairrks5 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_REPAIRTYPE = 'อุปกรณ์ประจำรถ'";
                        $params_getRepairrks5 = array();
                        $query_getRepairrks5 = sqlsrv_query($conn, $sql_getRepairrks5, $params_getRepairrks5);
                        $result_getRepairrks5 = sqlsrv_fetch_array($query_getRepairrks5, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkr5 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_REPAIRTYPE = 'อุปกรณ์ประจำรถ'";
                        $params_getRepairrkr5 = array();
                        $query_getRepairrkr5 = sqlsrv_query($conn, $sql_getRepairrkr5, $params_getRepairrkr5);
                        $result_getRepairrkr5 = sqlsrv_fetch_array($query_getRepairrkr5, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrkl5 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_REPAIRTYPE = 'อุปกรณ์ประจำรถ'";
                        $params_getRepairrkl5 = array();
                        $query_getRepairrkl5 = sqlsrv_query($conn, $sql_getRepairrkl5, $params_getRepairrkl5);
                        $result_getRepairrkl5 = sqlsrv_fetch_array($query_getRepairrkl5, SQLSRV_FETCH_ASSOC);
                    
                        ///////////////////////////////////////////////////////
                        
                        $sql_getRepairanyrks1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TEC_ANALYZE = 'อายุรถ'";
                        $params_getRepairanyrks1 = array();
                        $query_getRepairanyrks1 = sqlsrv_query($conn, $sql_getRepairanyrks1, $params_getRepairanyrks1);
                        $result_getRepairanyrks1 = sqlsrv_fetch_array($query_getRepairanyrks1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkr1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TEC_ANALYZE = 'อายุรถ'";
                        $params_getRepairanyrkr1 = array();
                        $query_getRepairanyrkr1 = sqlsrv_query($conn, $sql_getRepairanyrkr1, $params_getRepairanyrkr1);
                        $result_getRepairanyrkr1 = sqlsrv_fetch_array($query_getRepairanyrkr1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkl1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TEC_ANALYZE = 'อายุรถ'";
                        $params_getRepairanyrkl1 = array();
                        $query_getRepairanyrkl1 = sqlsrv_query($conn, $sql_getRepairanyrkl1, $params_getRepairanyrkl1);
                        $result_getRepairanyrkl1 = sqlsrv_fetch_array($query_getRepairanyrkl1, SQLSRV_FETCH_ASSOC);

                  
                        $sql_getRepairanyrks2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TEC_ANALYZE = 'อายุอะไหล่'";
                        $params_getRepairanyrks2 = array();
                        $query_getRepairanyrks2 = sqlsrv_query($conn, $sql_getRepairanyrks2, $params_getRepairanyrks2);
                        $result_getRepairanyrks2 = sqlsrv_fetch_array($query_getRepairanyrks2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkr2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TEC_ANALYZE = 'อายุอะไหล่'";
                        $params_getRepairanyrkr2 = array();
                        $query_getRepairanyrkr2 = sqlsrv_query($conn, $sql_getRepairanyrkr2, $params_getRepairanyrkr2);
                        $result_getRepairanyrkr2 = sqlsrv_fetch_array($query_getRepairanyrkr2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkl2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TEC_ANALYZE = 'อายุอะไหล่'";
                        $params_getRepairanyrkl2 = array();
                        $query_getRepairanyrkl2 = sqlsrv_query($conn, $sql_getRepairanyrkl2, $params_getRepairanyrkl2);
                        $result_getRepairanyrkl2 = sqlsrv_fetch_array($query_getRepairanyrkl2, SQLSRV_FETCH_ASSOC);
                  
                        $sql_getRepairanyrks3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TEC_ANALYZE = 'การใช้งานผิดประเภท'";
                        $params_getRepairanyrks3 = array();
                        $query_getRepairanyrks3 = sqlsrv_query($conn, $sql_getRepairanyrks3, $params_getRepairanyrks3);
                        $result_getRepairanyrks3 = sqlsrv_fetch_array($query_getRepairanyrks3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkr3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TEC_ANALYZE = 'การใช้งานผิดประเภท'";
                        $params_getRepairanyrkr3 = array();
                        $query_getRepairanyrkr3 = sqlsrv_query($conn, $sql_getRepairanyrkr3, $params_getRepairanyrkr3);
                        $result_getRepairanyrkr3 = sqlsrv_fetch_array($query_getRepairanyrkr3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkl3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TEC_ANALYZE = 'การใช้งานผิดประเภท'";
                        $params_getRepairanyrkl3 = array();
                        $query_getRepairanyrkl3 = sqlsrv_query($conn, $sql_getRepairanyrkl3, $params_getRepairanyrkl3);
                        $result_getRepairanyrkl3 = sqlsrv_fetch_array($query_getRepairanyrkl3, SQLSRV_FETCH_ASSOC);
                   
                        $sql_getRepairanyrks4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TEC_ANALYZE = 'การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ'";
                        $params_getRepairanyrks4 = array();
                        $query_getRepairanyrks4 = sqlsrv_query($conn, $sql_getRepairanyrks4, $params_getRepairanyrks4);
                        $result_getRepairanyrks4 = sqlsrv_fetch_array($query_getRepairanyrks4, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkr4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TEC_ANALYZE = 'การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ'";
                        $params_getRepairanyrkr4 = array();
                        $query_getRepairanyrkr4 = sqlsrv_query($conn, $sql_getRepairanyrkr4, $params_getRepairanyrkr4);
                        $result_getRepairanyrkr4 = sqlsrv_fetch_array($query_getRepairanyrkr4, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairanyrkl4 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TEC_ANALYZE = 'การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ'";
                        $params_getRepairanyrkl4 = array();
                        $query_getRepairanyrkl4 = sqlsrv_query($conn, $sql_getRepairanyrkl4, $params_getRepairanyrkl4);
                        $result_getRepairanyrkl4 = sqlsrv_fetch_array($query_getRepairanyrkl4, SQLSRV_FETCH_ASSOC);
                    
                        ///////////////////////////////////////////////////
                        
                        $sql_getRepairrutrks1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_RUNTYPE = '1'";
                        $params_getRepairrutrks1 = array();
                        $query_getRepairrutrks1 = sqlsrv_query($conn, $sql_getRepairrutrks1, $params_getRepairrutrks1);
                        $result_getRepairrutrks1 = sqlsrv_fetch_array($query_getRepairrutrks1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkr1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_RUNTYPE = '1'";
                        $params_getRepairrutrkr1 = array();
                        $query_getRepairrutrkr1 = sqlsrv_query($conn, $sql_getRepairrutrkr1, $params_getRepairrutrkr1);
                        $result_getRepairrutrkr1 = sqlsrv_fetch_array($query_getRepairrutrkr1, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkl1 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_RUNTYPE = '1'";
                        $params_getRepairrutrkl1 = array();
                        $query_getRepairrutrkl1 = sqlsrv_query($conn, $sql_getRepairrutrkl1, $params_getRepairrutrkl1);
                        $result_getRepairrutrkl1 = sqlsrv_fetch_array($query_getRepairrutrkl1, SQLSRV_FETCH_ASSOC);

                  
                        $sql_getRepairrutrks2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_RUNTYPE = '2'";
                        $params_getRepairrutrks2 = array();
                        $query_getRepairrutrks2 = sqlsrv_query($conn, $sql_getRepairrutrks2, $params_getRepairrutrks2);
                        $result_getRepairrutrks2 = sqlsrv_fetch_array($query_getRepairrutrks2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkr2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_RUNTYPE = '2'";
                        $params_getRepairrutrkr2 = array();
                        $query_getRepairrutrkr2 = sqlsrv_query($conn, $sql_getRepairrutrkr2, $params_getRepairrutrkr2);
                        $result_getRepairrutrkr2 = sqlsrv_fetch_array($query_getRepairrutrkr2, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkl2 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_RUNTYPE = '2'";
                        $params_getRepairrutrkl2 = array();
                        $query_getRepairrutrkl2 = sqlsrv_query($conn, $sql_getRepairrutrkl2, $params_getRepairrutrkl2);
                        $result_getRepairrutrkl2 = sqlsrv_fetch_array($query_getRepairrutrkl2, SQLSRV_FETCH_ASSOC);
                  
                        $sql_getRepairrutrks3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '02' AND TENKO_RUNTYPE = '3'";
                        $params_getRepairrutrks3 = array();
                        $query_getRepairrutrks3 = sqlsrv_query($conn, $sql_getRepairrutrks3, $params_getRepairrutrks3);
                        $result_getRepairrutrks3 = sqlsrv_fetch_array($query_getRepairrutrks3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkr3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '01' AND TENKO_RUNTYPE = '3'";
                        $params_getRepairrutrkr3 = array();
                        $query_getRepairrutrkr3 = sqlsrv_query($conn, $sql_getRepairrutrkr3, $params_getRepairrutrkr3);
                        $result_getRepairrutrkr3 = sqlsrv_fetch_array($query_getRepairrutrkr3, SQLSRV_FETCH_ASSOC);
                        
                        $sql_getRepairrutrkl3 = "SELECT COUNT(*) AS CNT
                        FROM [dbo].[EMPLOYEEREPAIR]
                        WHERE CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) 
                        AND SUBSTRING(DRIVERCODE,1,2) = '07' AND TENKO_RUNTYPE = '3'";
                        $params_getRepairrutrkl3 = array();
                        $query_getRepairrutrkl3 = sqlsrv_query($conn, $sql_getRepairrutrkl3, $params_getRepairrutrkl3);
                        $result_getRepairrutrkl3 = sqlsrv_fetch_array($query_getRepairrutrkl3, SQLSRV_FETCH_ASSOC);
                        
                      
            
            ?>
            <tr style="border:1px solid #000;">
                <td style="border:1px solid #000;padding:3px;text-align:center;">1</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">RKS</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks5['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrks1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrks2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrks3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                
                
            </tr>
            <tr style="border:1px solid #000;">
                <td style="border:1px solid #000;padding:3px;text-align:center;">2</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">RKR</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkr1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkr2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkr3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkr4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkr5['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkr1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkr2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkr3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkr4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkr1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkr2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkr3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                
            </tr>
            <tr style="border:1px solid #000;">
                <td style="border:1px solid #000;padding:3px;text-align:center;">3</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">RKL</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkl1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkl2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkl3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkl4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrkl5['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkl1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkl2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkl3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrkl4['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">0</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkl1['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkl2['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkl3['CNT']?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                
            </tr>


    </tbody>
    
    
            
            
    <tfoot>
        <tr style="border:1px solid #000;">
            <td colspan="2" rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;">Complate Total</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks1['CNT']+$result_getRepairrkr1['CNT']+$result_getRepairrkl1['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks2['CNT']+$result_getRepairrkr2['CNT']+$result_getRepairrkl2['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks3['CNT']+$result_getRepairrkr3['CNT']+$result_getRepairrkl3['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks4['CNT']+$result_getRepairrkr4['CNT']+$result_getRepairrkl4['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks5['CNT']+$result_getRepairrkr5['CNT']+$result_getRepairrkl5['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks1['CNT']+$result_getRepairanyrkr1['CNT']+$result_getRepairanyrkl1['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks2['CNT']+$result_getRepairanyrkr2['CNT']+$result_getRepairanyrkl2['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks3['CNT']+$result_getRepairanyrkr3['CNT']+$result_getRepairanyrkl3['CNT']?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairanyrks4['CNT']+$result_getRepairanyrkr4['CNT']+$result_getRepairanyrkl4['CNT']?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;">0</td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;">0</td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrks1['CNT']+$result_getRepairrutrks2['CNT']+$result_getRepairrutrks3['CNT']?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkr1['CNT']+$result_getRepairrutrkr2['CNT']+$result_getRepairrutrkr3['CNT']?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrutrkl1['CNT']+$result_getRepairrutrkl2['CNT']+$result_getRepairrutrkl3['CNT']?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;">-</td>

        </tr>
        <tr style="border:1px solid #000;">
           
            <td colspan="9" style="border:1px solid #000;padding:3px;text-align:center;"><?=$result_getRepairrks1['CNT']+$result_getRepairrkr1['CNT']+$result_getRepairrkl1['CNT']+
            $result_getRepairrks2['CNT']+$result_getRepairrkr2['CNT']+$result_getRepairrkl2['CNT']+
            $result_getRepairrks3['CNT']+$result_getRepairrkr3['CNT']+$result_getRepairrkl3['CNT']+
            $result_getRepairrks4['CNT']+$result_getRepairrkr4['CNT']+$result_getRepairrkl4['CNT']+
            $result_getRepairrks5['CNT']+$result_getRepairrkr5['CNT']+$result_getRepairrkl5['CNT']+
            $result_getRepairanyrks1['CNT']+$result_getRepairanyrkr1['CNT']+$result_getRepairanyrkl1['CNT']+
            $result_getRepairanyrks2['CNT']+$result_getRepairanyrkr2['CNT']+$result_getRepairanyrkl2['CNT']+
            $result_getRepairanyrks3['CNT']+$result_getRepairanyrkr3['CNT']+$result_getRepairanyrkl3['CNT']+
            $result_getRepairanyrks4['CNT']+$result_getRepairanyrkr4['CNT']+$result_getRepairanyrkl4['CNT']?>
            </td>
            

        </tr>
    </tfoot>
</table>



<?php
sqlsrv_close($conn);
?>
