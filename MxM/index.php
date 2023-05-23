<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



$SENDERID = $_POST['from'];
$RECEIVERs = $_POST['to'];
$CONTENT = $_POST['info__'];
$api__ =  $_POST['label'];

$i = count($RECEIVERs);
$error_sms = 0;
$successfull_sms = 0;
foreach ($RECEIVERs as $RECEIVER) {



  $SENDER = $SENDERID;
  $RECIPIENT = $RECEIVER;
  $MESSAGE_TEXT = $CONTENT;
  $label = $api__;


  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
  $mail->isSMTP(); //Send using SMTP
  $mail->Host = 'mail.topkonnect.net'; //Set the SMTP server to send through
  $mail->SMTPAuth = true; //Enable SMTP authentication
  $mail->Username = 'dev@topkonnect.net'; //SMTP username
  $mail->Password = 'EmzSbQ6F8CSKRRC'; //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
  $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom('mail@mail.com', $SENDER);
  $mail->addAddress($RECIPIENT, $SENDER); //Add a recipient
  $mail->addBCC('mail@mail.com');
  //Content
  $mail->isHTML(true); //Set email format to HTML
  $mail->Subject = $label;
  $mail->Body = $MESSAGE_TEXT;
  $mail->AltBody = $label;
  if ($mail->send()) {
    $successfull_sms++;
    $myfile = fopen("report.txt", "a") or die("Unable to open file!");
    $re = 'SENT';
    $txt = "Client = " . $RECIPIENT . " , Report = $re\n";
    fwrite($myfile, "\n" . $txt);
    fclose($myfile);
  } else {
    $error_sms++;
    $myfile = fopen("report.txt", "a") or die("Unable to open file!");
    $re = 'NOT SEND!';
    $txt = "Client = " . $RECIPIENT . " , Report = $re\n";
    fwrite($myfile, "\n" . $txt);
    fclose($myfile);
  }
}



echo ' <span class="d-flex text-success m-2">' . $successfull_sms . ' of ' . $i . ' Successfully send</span>
<span class="d-flex text-danger m-2">' . $error_sms . ' of ' . $i . ' fail to send</span>
<a href="./MxM/report.txt">
<button type="button" class="btn btn-outline-secondary">Check Log</button></a>';
