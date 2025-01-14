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
            <td colspan="24" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สถานะรถซ่อม Update <?= $_GET['datestart'] ?>-<?= $_GET['dateend'] ?> Update Time : 16.30</b>
            </td>

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ลำดับ</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ชื่อผู้แจ้ง</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สายงาน</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>ทะเบียน</b>
            </td>

            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลาแจ้งซ่อม</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>เวลาซ่อมเสร็จ</b>
            </td>

            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สาเหตุ</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การแก้ไข</b>
            </td>
            <td colspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การวิเคราะห์</b>
            </td>
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>Traler not complete</b>
            </td>
            <td colspan="2" rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>สถานะปัจจุบัน</b>
            </td>
            <td colspan="3" rowspan="2" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การตรวจพบ</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>กำหนดเสร็จ</b>
            </td>
            <td rowspan="4" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>หมายเหตุ</b>
            </td>

        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >

            <td rowspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อายุรถ</b>
            </td>
            <td rowspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>อายุอะไหล่</b>
            </td>
            <td rowspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การใช้งานผิดประเภท</b>
            </td>
            <td rowspan="3" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ</b>
            </td>
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>BM</b>
            </td>


        </tr>
        <tr style="border:1px solid #000;background-color: #ccc" >
            <td colspan="5" style="border-right:1px solid #000;padding:3px;text-align:center;">
                <b>AMT</b>
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
        $condRepair = " AND CONVERT(DATE,CREATEDATE,103) BETWEEN CONVERT(DATE,'" . $_GET['datestart'] . "',103) AND CONVERT(DATE,'" . $_GET['dateend'] . "',103) ";
        $sql_getRepair = "{call megRepair_v2(?,?)}";
        $params_getRepair = array(
            array('select_repair', SQLSRV_PARAM_IN),
            array($condRepair, SQLSRV_PARAM_IN)
        );
        $query_getRepair = sqlsrv_query($conn, $sql_getRepair, $params_getRepair);
        while ($result_getRepair = sqlsrv_fetch_array($query_getRepair, SQLSRV_FETCH_ASSOC)) {

            switch ($result_getRepair['TEC_ANALYZE']) {
                case 'อายุรถ': {
                        $checkanalyze1 = " &check;";
                        
                    }
                    break;
                case 'อายุอะไหล่': {
                        $checkanalyze2 = " &check;";
                       
                    }
                    break;
                case 'การใช้งานผิดประเภท': {
                        $checkanalyze3 = " &check;";
                     
                    }
                    break;
                case 'การซ่อมบำรุงที่ไม่ได้ประสิทธิภาพ': {
                        $checkanalyze4 = " &check;";
                      
                    }
                    break;
            }
            switch ($result_getRepair['TENKO_REPAIRTYPE']) {
                case 'ระบบไฟ': {
                        $checkrepair1 = " &check;";
                        $cntrepair1 = $cntrepair1+$i;
                    }
                    break;
                case 'ยางช่วงล่าง': {
                        $checkrepair2 = " &check;";
                        $cntrepair2 = $cntrepair2+$i;
                    }
                    break;
                case 'โครงสร้าง': {
                        $checkrepair3 = " &check;";
                        $cntrepair3 = $cntrepair3+$i;
                    }
                    break;
                case 'เครื่องยนต์': {
                        $checkrepair4 = " &check;";
                        $cntrepair4 = $cntrepair4+$i;
                    }
                    break;
                case 'อุปกรณ์ประจำรถ': {
                        $checkrepair5 = " &check;";
                        $cntrepair5 = $cntrepair5+$i;
                    }
                    break;
            }
            $cntrepair = $cntrepair1+$cntrepair2+$cntrepair3+$cntrepair4+$cntrepair5;
            switch ($result_getRepair['TENKO_RUNTYPE']) {
                case '1': {
                        $checkruntype1 = " &check;";
                        $cntruntype1 = $cntruntype1+$i;
                    }
                    break;
                case '2': {
                        $checkruntype2 = " &check;";
                        $cntruntype2 = $cntruntype2+$i;
                    }
                    break;
                case '3': {
                        $checkruntype3 = " &check;";
                        $cntruntype3 = $cntruntype3+$i;
                    }
                    break;
               
            }
            ?>
            <tr style="border:1px solid #000;">
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $i ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['DRIVERNAME'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['VEHICLENUMBER'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['CREATEDATETIME'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['TEC_COMPLETED'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['TEC_CAUSE'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['TEC_EDIT'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkanalyze1 ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkanalyze2 ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkanalyze3 ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkanalyze4 ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkrepair1?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkrepair2?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkrepair3?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkrepair4?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $checkrepair5?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;">-</td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$checkruntype1?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$checkruntype2?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$checkruntype3?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['TEC_COMPLETED'] ?></td>
                <td style="border:1px solid #000;padding:3px;text-align:center;"><?= $result_getRepair['REMARK'] ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>

    </tbody>
    <tfoot>
        <tr style="border:1px solid #000;">
            <td colspan="12" rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;">Complate Total</td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair1?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair2?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair3?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair4?></td>
            <td style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair5?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntruntype1?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntruntype2?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntruntype3?></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"></td>
            <td rowspan="2" style="border:1px solid #000;padding:3px;text-align:center;"></td>

        </tr>
        <tr style="border:1px solid #000;">
           
            <td colspan="5" style="border:1px solid #000;padding:3px;text-align:center;"><?=$cntrepair?></td>
            

        </tr>
    </tfoot>
</table>



<?php
sqlsrv_close($conn);
?>
