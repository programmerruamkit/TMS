<?php

/* * *
  Server SMTP/POP : mail.thaicreate.com
  Email Account : webmaster@thaicreate.com
  Password : 123456
 */
if (require_once 'master.php'){

$text = "My Body & <b>My Description</b><br>Test Message for My data";

$mail = new PHPMailer(true);
$mail->IsHTML(true);
$mail->IsSMTP();
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->SMTPSecure = ""; // sets the prefix to the servier
$mail->Host = "mail.ruamkit.co.th"; // sets GMAIL as the SMTP server
$mail->Port = 25; // set the SMTP port for the GMAIL server
$mail->Username = $person_mail; // GMAIL username
$mail->Password = "Ruamkit@1993"; // GMAIL password
$mail->From = $person_mail; // "name@yourdomain.com";
//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
$mail->FromName = $create_by;  // set from Name
$mail->Subject = $order_name;
$mail->Body = $text;

$mail->AddAddress("niti_it@ruamkit.co.th", "Admin IT"); // to Address

$mail->Send();

}

?>