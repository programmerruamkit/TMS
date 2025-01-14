<?php
ob_start();
date_default_timezone_set("Asia/Bangkok");
require_once("../mpdf/autoload.php");
require_once("../class/meg_function.php");
require("../PHPMailer-5.1.0/class.phpmailer.php");  // ประกาศใช้ class phpmailer กรุณาตรวจสอบ ว่าประกาศถูก path
$conn = connect("RTMS");

try {
    $sql_getDate = "{call megStopwork_v2(?)}";
    $params_getDate = array(
        array('select_getdate', SQLSRV_PARAM_IN)
    );
    $query_getDate = sqlsrv_query($conn, $sql_getDate, $params_getDate);
    $result_getDate = sqlsrv_fetch_array($query_getDate, SQLSRV_FETCH_ASSOC);

    $sql_getWarningrepair = "{call megWarningdata_v2(?)}";
    $params_getWarningrepair = array(
        array('select_warningrepair', SQLSRV_PARAM_IN)
    );
    $query_getWarningrepair = sqlsrv_query($conn, $sql_getWarningrepair, $params_getWarningrepair);
    $result_getWarningrepair = sqlsrv_fetch_array($query_getWarningrepair, SQLSRV_FETCH_ASSOC);

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";       // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
    $mail->Host = "mail.ruamkit.co.th";      //  mail server ของเรา
    $mail->SMTPAuth = true;            //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "Ruamkit1993";         //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง
    $mail->From = "wittawat_it@ruamkit.co.th";     //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "คุณ".$_GET['tenkoname']; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
              // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
    $emailto = explode(",", $result_getWarningrepair['EMAILTO']);
    foreach ($emailto as $data1) {
        $mail->AddAddress($data1);
    }
    
    $emailcc = explode(",", $result_getWarningrepair['EMAILCC']);
    foreach ($emailcc as $data2) {
        $mail->AddCC($data2);
    }
                   // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
    $mail->Subject = $result_getWarningrepair['SUBJECT'];        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body = 
    "
    เรียนคุณ ทดสอบ ทดสอบ
    
            มีรายการแจ้งซ่อม ทะเบียนรถ : 123456 จำนวน 1 รายการ
            คลิกลิ้งเพื่อยืนยันดำเนินรับแจ้งซ่อม http://http://203.150.225.30:8080/job/progress.php?warningdataid=".$result_getWarningrepair['WARNINGDATAID']."
            
    ผู้แจ้งซ่อม
    นายแจ้งซ่อม แจ้งซ่อม
    ";

    $result = $mail->send();

    $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array('save_logsendemail', SQLSRV_PARAM_IN),
        array($result_getWarningrepair['WARNINGDATAID'], SQLSRV_PARAM_IN),
        array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILTO'], SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILCC'], SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILEXTRA'], SQLSRV_PARAM_IN),
        array('-', SQLSRV_PARAM_IN),
        array('รอดำเนินการ', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
} catch (Exception $e) {
    $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array('save_logsendemail', SQLSRV_PARAM_IN),
        array($result_getWarningrepair['VEHICLEINSUREDID'], SQLSRV_PARAM_IN),
        array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILTO'], SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILCC'], SQLSRV_PARAM_IN),
        array($result_getWarningrepair['EMAILEXTRA'], SQLSRV_PARAM_IN),
        array($e->getMessage(), SQLSRV_PARAM_IN),
        array('0', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
}
sqlsrv_close($conn);
?>
<script langauge="javascript">
    window.open('', '_self');
    self.close();
</script>