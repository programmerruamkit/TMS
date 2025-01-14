<?php

	/***
	Server SMTP/POP : mail.thaicreate.com
	Email Account : webmaster@thaicreate.com
	Password : 123456
	*/
	require_once('class.phpmailer.php');

	$mail = new PHPMailer();
	$mail->IsHTML(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->SMTPSecure = ""; // sets the prefix to the servier
	$mail->Host = "mail.ruamkit.co.th"; // sets GMAIL as the SMTP server
	$mail->Port = 25; // set the SMTP port for the GMAIL server
	$mail->Username = "niti_it@ruamkit.co.th"; // GMAIL username
	$mail->Password = "Ruamkit@1993"; // GMAIL password
	$mail->From = "niti_it@ruamkit.co.th"; // "name@yourdomain.com";
	//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
	$mail->FromName = "Mr.Niti";  // set from Name
	$mail->Subject = "Test sending mail."; 
	$mail->Body = "My Body & <b>My Description</b>";

	$mail->AddAddress("ing_zaa@hotmail.com", "Mr.Adisorn Boonsong"); // to Address

	$mail->Send(); 
?>