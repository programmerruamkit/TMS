<?php
ob_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../class/meg_function.php");
require("../PHPMailer-5.1.0/class.phpmailer.php");  // ประกาศใช้ class phpmailer กรุณาตรวจสอบ ว่าประกาศถูก path
$conn = connect("RTMS");
try {

    $sql_getEmailextra = "{call megLogsendemail_v2(?)}";
    $params_getEmailextra = array(
        array('get_logsendemail', SQLSRV_PARAM_IN)
    );
    $query_getEmailextra = sqlsrv_query($conn, $sql_getEmailextra, $params_getEmailextra);
    while ($result_getEmailextra = sqlsrv_fetch_array($query_getEmailextra, SQLSRV_FETCH_ASSOC)) {
        if ($result_getEmailextra['WARNINGDAY'] > 3) {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = "utf-8";       // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
            $mail->Host = "mail.ruamkit.co.th";      //  mail server ของเรา
            $mail->SMTPAuth = true;            //  เลือกการใช้งานส่งเมล์ แบบ SMTP
            $mail->Username = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ต้องการจะส่ง
            $mail->Password = "Ruamkit1993";         //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง
            $mail->From = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ใช้ในการส่งอีเมล
            $mail->FromName = "easyinfo@ruamkit.co.th"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
            $mail->AddAddress($result_getEmailextra['EMAILEXTRA']);            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
            $mail->IsHTML(false);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
            $mail->Subject = 'ไม่ดำเนินการเกิน 3 วัน';        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
            $mail->Body = 'อีเมล ' . $result_getEmailextra['EMAILTO'] . ' ไม่ดำเนินการเกิน 3 วัน';                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
            $result = $mail->send();

            $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
            $params = array(
                array('save_logsendemail', SQLSRV_PARAM_IN),
                array($result_getEmailextra['LOGSENDEMAILID'], SQLSRV_PARAM_IN),
                array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
                array($result_getEmailextra['EMAILTO'], SQLSRV_PARAM_IN),
                array($result_getEmailextra['EMAILCC'], SQLSRV_PARAM_IN),
                array($result_getEmailextra['EMAILEXTRA'], SQLSRV_PARAM_IN),
                array('', SQLSRV_PARAM_IN),
                array('รอดำเนินการ', SQLSRV_PARAM_IN)
            );
            $query = sqlsrv_query($conn, $sql, $params);
        }
    }
} catch (Exception $e) {
    $sql_getEmailextra = "{call megLogsendemail_v2(?)}";
    $params_getEmailextra = array(
        array('get_logsendemail', SQLSRV_PARAM_IN)
    );
    $query_getEmailextra = sqlsrv_query($conn, $sql_getEmailextra, $params_getEmailextra);
    while ($result_getEmailextra = sqlsrv_fetch_array($query_getEmailextra, SQLSRV_FETCH_ASSOC)) {
        $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
        $params = array(
            array('save_logsendemail', SQLSRV_PARAM_IN),
            array($result_getEmailextra['LOGSENDEMAILID'], SQLSRV_PARAM_IN),
            array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
            array($result_getEmailextra['EMAILTO'], SQLSRV_PARAM_IN),
            array($result_getEmailextra['EMAILCC'], SQLSRV_PARAM_IN),
            array($result_getEmailextra['EMAILEXTRA'], SQLSRV_PARAM_IN),
            array($e->getMessage(), SQLSRV_PARAM_IN),
            array('0', SQLSRV_PARAM_IN)
        );
        $query = sqlsrv_query($conn, $sql, $params);
    }
}


sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>