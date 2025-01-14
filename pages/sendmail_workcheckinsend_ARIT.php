<?php
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
$conn = connect("RTMS");
require("../PHPMailer-5.1.0/class.phpmailer.php");

$sql_getDate = "{call megGetdate_v2(?)}";
$params_getDate = array(
    array('select_getdate', SQLSRV_PARAM_IN)
);
$query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
$result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

try {
    $my_path = "D:\Downloads\Report".$result_getDate['GETDATE']."_ARIT.xls";
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";       // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
    $mail->Host = "mail.ruamkit.co.th";      //  mail server ของเรา
    $mail->SMTPAuth = true;            //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "Ruamkit1993";         //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง
    $mail->From = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "ระบบส่งอีเมลล์อัตโนมัติ"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
    $mail->AddAddress("santi@ruamkit.co.th");//santi@ruamkit.co.th
    $mail->AddCC("Wittawat_it@ruamkit.co.th");
    $mail->AddAttachment($my_path);
    


    $mail->Subject = "รายงานตัวปฎิบัติงานนอกสถานที่";        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body = "
    เรียนคุณสันติ ประกอบกิจ

            รายงานตัวปฎิบัติงานนอกสถานที่ ฝ่าย : Affiliate Business แผนก : Ruamkit Information Technology
    วันที่ ".$result_getDate['GETDATE']." ถึง ".$result_getDate['GETDATE']."

    ขอแสดงความนับถือ
    กลุ่มบริษัท ร่วมกิจรุ่งเรือง จำกัด
    ";

    $result = $mail->send();
} catch (Exception $e) {
    
}
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>