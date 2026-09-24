<?php

//phpinfo();
//exit;
//echo "ingresa a enviar";
include_once '../inc/config.inc.php';

header('Content-type: application/json');

//echo CONF_SITE_URLPHP;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/Exception.php';
require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/PHPMailer.php';
require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->Port       = 25;
$mail->SMTPSecure = tls;
$mail->CharSet="UTF-8";
$mail->Username = 'servicios@perfecta.com.py';
$mail->Password = 'Perfecta2019';
$mail->SMTPAuth = true;
$mail->From = 'servicios@perfecta.com.py';
$mail->FromName = "MARIA PRUEBA";
$mail->IsHTML(true);
$mail->Timeout = 60;
$mail->AddEmbeddedImage(CONF_ABS_ROOT_PATH . 'mail_template/images/perfecta-logo.jpg', 'logo_perfecta');
$mail->CharSet = 'UTF-8';
$mail->SMTPDebug  = 4;
$mail->Subject = "PRUEBA";
$mail->AddCC('maria.cruz@perfecta.com.py', 'Maria Cruz');
$cuerpo = "PRUEBA";
$mail->MsgHTML($cuerpo);


 if(!$mail->send()){
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  }else{
echo "debería enviar el correo";
}
