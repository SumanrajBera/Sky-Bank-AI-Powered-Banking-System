<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'srbera17@gmail.com';
$mail->Password   = 'hgbictgnarokecxi';
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;

$mail->setFrom('srbera17@gmail.com');

$mail->addAddress('berasumanraj@gmail.com');

$mail->isHTML(true);

$mail->Subject = "Congratulations on creating account with Sky Bank";

$bodyContent = "<h1>Hello testing</h1>";

$mail->Body = $bodyContent;

$mail->send();


