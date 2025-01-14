<?php

date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
$conn = connect("RTMS");
$sumgmtweight = "";
$sumcusweight = "";
$sumamounttrip = "";
$sumtotal = "";
if ($_GET['datestart'] == "" || $_GET['dateend'] == "") {
    $date_now = "";
} else {
    $date_now = $_GET['datestart'] . ' ถึง ' . $_GET['dateend'];
}
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);




//$invoicecode = create_invoice();

$mpdf = new mPDF('th', 'A4', '0', '');
$style = '
<style>
	body{
		font-family: "Garuda";font-size:12px//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';



$table_header1 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:18px;"><b>รายงานสรุปรายการวางบิลลูกค้า</b></td>

    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="text-align:center;font-size:14px;"><b>21/12/2561-27/12/2561 (ค่าขนส่งปกติ)</b></td>
       </tr>

       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>

    </tbody>
</table>';

$table_begin1 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead1 = '<thead>
        <tr>
            <td colspan="10" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : TXOA Charge 10</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ใบแจ้งหนี้</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>Zone</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ปริมาณ(ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคา(บาท)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคาจริง(บาท)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ผลต่าง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเหตุ</b></td>
      </tr>
    </thead><tbody>';





    $tbody1 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        </tr>';


$tfoot1 = '</tbody><tfoot>
        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">418.543</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;">89,073.48</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        </tr>
    </tfoot>';


$table_end1 = '</table>';

$table_footer1 = '<table style="width: 100%;">
    <tbody>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>
       <tr>
   		 <td colspan="4">&nbsp;</td>
       </tr>

       <tr>
   		 <td style="width: 10%;text-align:right">ผู้จัดทำ</td>
            <td style="width: 25%;">........................................</td>
         <td style="width: 10%;text-align:right">ผู้ตรวจสอบ</td>
            <td style="width: 20%;">........................................</td>
            <td style="width: 10%;text-align:right">ผู้อนุมัติ</td>
            <td style="width: 25%;">........................................</td>
       </tr>



    </tbody>
</table>';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$table_header2 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (ไม่คิดขั้นต่ำ)</b></td>

    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="text-align:center;font-size:14px;"><b>21/12/2561-27/12/2561 (ค่าขนส่งปกติ)</b></td>
       </tr>

       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>

    </tbody>
</table>';

$table_begin2 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead2 = '<thead>
        <tr>
            <td colspan="8" style="text-align:left;font-size:16px;"><b>หมายเลขบัญชี : TXOA Charge 10</b></td>
            <td colspan="3" style="text-align:right;font-size:16px;"><b>ใบแจ้งหนี้: RKL6201-04</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 5%;"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Zone</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ปริมาณ(ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ราคา(บาท)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>หมายเลขรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>พนักงาน</b></td>
      </tr>
    </thead><tbody>';





    $tbody2 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        </tr>';


$tfoot2 = '</tbody><tfoot>
        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">8.010</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">2,242.80</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        </tr>
    </tfoot>';


$table_end2 = '</table>';

////////////////////////////////////////////////////////////////////////////////////////////////////////////
$table_header3 = '<table style="width: 100%;">
    <thead>
        <tr>
            <td colspan="2" style="text-align:center;font-size:18px;"><b>เอกสารแนบการวางบิลลูกค้า (คิดขั้นต่ำ)</b></td>

    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="text-align:center;font-size:14px;"><b>21/12/2561-27/12/2561 (ค่าขนส่งปกติ)</b></td>
       </tr>

       <tr>
            <td colspan="2">&nbsp;</td>
       </tr>

    </tbody>
</table>';

$table_begin3 = '<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
$thead3 = '<thead>
        <tr>
            <td colspan="10" style="text-align:left;font-size:18px;"><b>หมายเลขบัญชี : TXOA Charge 10</b></td>
            <td colspan="3" style="text-align:right;font-size:18px;"><b>ใบแจ้งหนี้: RKL6201-04</b></td>
        </tr>
        <tr style="border:1px solid #000;padding:4px;">

        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 6%;"><b>ลำดับ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>วันที่</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>จาก</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ถึง</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>Zone</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 20%;"><b>หมายเลข DO</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ปริมาณ(ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>อัตรา(บาท/ตัน)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคา(บาท)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>หมายเลขรถ</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>พนักงาน</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 15%;"><b>ราคาจริง(บาท)</b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;width: 10%;"><b>ผลต่าง</b></td>
      </tr>
    </thead><tbody>';





    $tbody3 .= '

        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:5px;text-align:center;"></td>
        </tr>';


$tfoot3 = '</tbody><tfoot>
        <tr style="border:1px solid #000;">
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"><b>รวม<b></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">8.010</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">2,242.80</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;"></td>
        <td style="border-right:1px solid #000;padding:4px;text-align:right;">1,345.68</td>
        <td style="border-right:1px solid #000;padding:4px;text-align:center;">1,454.32</td>
        </tr>
    </tfoot>';


$table_end3 = '</table>';




$mpdf->WriteHTML($style);
$mpdf->WriteHTML($table_header1);
$mpdf->WriteHTML($table_begin1);
$mpdf->WriteHTML($thead1);
$mpdf->WriteHTML($tbody1);
$mpdf->WriteHTML($tfoot1);
$mpdf->WriteHTML($table_end1);
$mpdf->WriteHTML($table_footer1);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header2);
$mpdf->WriteHTML($table_begin2);
$mpdf->WriteHTML($thead2);
$mpdf->WriteHTML($tbody2);
$mpdf->WriteHTML($tfoot2);
$mpdf->WriteHTML($table_end2);
$mpdf->AddPage();
$mpdf->WriteHTML($table_header3);
$mpdf->WriteHTML($table_begin3);
$mpdf->WriteHTML($thead3);
$mpdf->WriteHTML($tbody3);
$mpdf->WriteHTML($tfoot3);
$mpdf->WriteHTML($table_end3);



$mpdf->Output();


sqlsrv_close($conn);
?>
