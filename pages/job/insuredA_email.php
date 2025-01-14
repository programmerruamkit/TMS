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


    $mpdf = new mPDF();
    $style = '
<style>
	body{
		font-family: "Garuda";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
	}
</style>';
    $title = '<h2 style="text-align:center">รายงานแจ้งเตือนหมดอายุข้อมูลประกันภัย</h2>';
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
    }
    $table_end = '</table>';

    @unlink('../pdffile/' . '0101_' . $result_getDate['GETDATE'] . '_unsuccess.pdf');
    $filename = '../pdffile/' . '0101_' . $result_getDate['GETDATE'] . '_success.pdf';

    $mpdf->WriteHTML($style);
    $mpdf->WriteHTML($title);
    $mpdf->WriteHTML($table_begin);
    $mpdf->WriteHTML($tr);
    $mpdf->WriteHTML($td);
    $mpdf->WriteHTML($table_end);
    $mpdf->Output($filename);





    $sql_getWarninginsured = "{call megWarningdata_v2(?)}";
    $params_getWarninginsured = array(
        array('select_warninginsuredA', SQLSRV_PARAM_IN)
    );
    $query_getWarninginsured = sqlsrv_query($conn, $sql_getWarninginsured, $params_getWarninginsured);
    $result_getWarninginsured = sqlsrv_fetch_array($query_getWarninginsured, SQLSRV_FETCH_ASSOC);



    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet = "utf-8";       // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
    $mail->Host = "mail.ruamkit.co.th";      //  mail server ของเรา
    $mail->SMTPAuth = true;            //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "Ruamkit1993";         //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง
    $mail->From = "easyinfo@ruamkit.co.th";     //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "easyinfo@ruamkit.co.th"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
    $mail->AddAddress($result_getWarninginsured['EMAILTO']);            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)

    $emailcc = explode(",", $result_getWarninginsured['EMAILCC']);
    foreach ($emailcc as $data) {
        $mail->AddCC($data);
    }
    $mail->AddAttachment($filename, basename($filename), "quoted-printable", "application/vnd.ms-excel");
    $mail->IsHTML(false);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
    $mail->Subject = $result_getWarninginsured['SUBJECT'];        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body = $result_getWarninginsured['DISCRIPTION'].' คลิกลิ้งเพื่อยืนยันดำเนินการ http://http://203.150.225.30:8080/job/progress.php?warningdataid='.$result_getWarninginsured['WARNINGDATAID'];                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
    $result = $mail->send();



    
    $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array('save_logsendemail', SQLSRV_PARAM_IN),
        array($result_getWarninginsured['WARNINGDATAID'], SQLSRV_PARAM_IN),
        array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILTO'], SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILCC'], SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILEXTRA'], SQLSRV_PARAM_IN),
        array('-', SQLSRV_PARAM_IN),
        array('รอดำเนินการ', SQLSRV_PARAM_IN)
    );
    $query = sqlsrv_query($conn, $sql, $params);
} catch (Exception $e) {
    $sql = "{call megLogsendemail_v2(?,?,?,?,?,?,?,?)}";
    $params = array(
        array('save_logsendemail', SQLSRV_PARAM_IN),
        array($result_getWarninginsured['VEHICLEINSUREDID'], SQLSRV_PARAM_IN),
        array('easyinfo@ruamkit.co.th', SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILTO'], SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILCC'], SQLSRV_PARAM_IN),
        array($result_getWarninginsured['EMAILEXTRA'], SQLSRV_PARAM_IN),
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