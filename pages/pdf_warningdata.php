<?php
ob_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require_once("../mpdf/autoload.php");
require("../PHPMailer-5.1.0/class.phpmailer.php");  // ประกาศใช้ class phpmailer กรุณาตรวจสอบ ว่าประกาศถูก path
$conn = connect("RTMS");
$sql_getDate = "{call megStopwork_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

$filename = "";
$mpdf = new mPDF();
$style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
$title = '<h2 style="text-align:center">รายงานแจ้งเตือนหมดอายุ' . $_GET['type'] . '</h2>';

switch ($_GET['type']) {
    case 'ข้อมูลประกันภัย': {
            $table_begin = '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
            $tr = '
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">เลขกรมธรรม์</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">ประเภทประกันภัย</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">เบี้ยประกันภัย</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">วงเงินความคุ้มครองสูงสุด</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">วันที่เริ่มต้นความคุ้มครอง</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">วันที่สิ้นสุดความคุ้มครอง</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ชื่อบริษัทผู้เอาประกันภัย</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ชื่อนายหน้าประกันภัย</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ชื่อบริษัทประกันภัย</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="5%">เหลือ(วัน)</td>
        
    </tr>';
            $filename = '0101_' . $result_getDate['GETDATE'];
            $sql_seWarning = "{call megVehicleinsured_v2(?)}";
            $params_seWarning = array(
                array('get_vehicleinsuredA', SQLSRV_PARAM_IN)
            );
            $query_seWarning = sqlsrv_query($conn, $sql_seWarning, $params_seWarning);
            while ($result_seWarning = sqlsrv_fetch_array($query_seWarning, SQLSRV_FETCH_ASSOC)) {

                $td .= '                          
            <tr style="border:1px solid #000;">
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['POLICYNUMBER'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >ประกันภัยชั้น ' . $result_seWarning['INSUREDTYPE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['PRICETOTAL'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['SUMINSURED'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['STARTDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['EXPIREDDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['INSUREDNAME'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['BROKERNAME'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['INSUREDCOMPANY'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['WARNINGDAY'] . '</td>
            </tr>';
                $table_end = '</table>';
            }
        }
        break;
    default : {
            $table_begin = '
<table id="bg-table" width="100%" style="border-collapse: collapse;font-size:10;margin-top:8px;">';
            $tr = '
    <tr style="border:1px solid #000;padding:4px;">
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">วันที่เริ่มเสียภาษี</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">วันที่หมดอายุ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ราคา (ราคา)</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">ค่าธรรมเนียม</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="15%">ผู้ดำเนินการ</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="25%">สถานที่</td>
        <td  style="border-right:1px solid #000;padding:4px;text-align:center;" width="10%">เหลือ(วัน)</td>
        
    </tr>';
            $filename = '0102_' . $result_getDate['GETDATE'];
            $sql_seWarning = "{call megVehicletax_v2(?)}";
            $params_seWarning = array(
                array('get_vehicletaxA', SQLSRV_PARAM_IN)
            );
            $query_seWarning = sqlsrv_query($conn, $sql_seWarning, $params_seWarning);
            while ($result_seWarning = sqlsrv_fetch_array($query_seWarning, SQLSRV_FETCH_ASSOC)) {

                $td .= '                          
            <tr style="border:1px solid #000;">
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['TAXDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['EXPIREDDATE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['PRICE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['SERVICEFEE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['WHOPROCESS'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['PLACE'] . '</td>
                    <td style="border-right:1px solid #000;padding:3px;text-align:center;" >' . $result_seWarning['WARNINGDAY'] . '</td>
            </tr>';
                $table_end = '</table>';
            }
            break;
        }
}


$filename = '../pdffile/' . $filename . '.pdf';
$mpdf->WriteHTML($style);
$mpdf->WriteHTML($title);
$mpdf->WriteHTML($table_begin);
$mpdf->WriteHTML($tr);
$mpdf->WriteHTML($td);
$mpdf->WriteHTML($table_end);
$mpdf->Output($filename);
sqlsrv_close($conn);
?>

<?php
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = "utf-8";       // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
$mail->Host = "mail.ruamkit.co.th";      //  mail server ของเรา
$mail->SMTPAuth = true;            //  เลือกการใช้งานส่งเมล์ แบบ SMTP
$mail->Username = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ต้องการจะส่ง
$mail->Password = "Ruamkit1993";         //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง
$mail->From = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ใช้ในการส่งอีเมล
$mail->FromName = "easyinfo@ruamkit.co.th"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
$mail->AddAddress($_GET['email']);            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
$mail->AddAttachment($filename, basename($filename), "quoted-printable", "application/vnd.ms-excel");
$mail->IsHTML(false);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
$mail->Subject = $_GET['subject'];        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
$mail->Body = $_GET['body'];                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
$result = $mail->send();
?>
<script>
    window.close();
</script>