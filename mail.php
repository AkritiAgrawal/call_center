<?php
include('sendMail.class.php');

$mail=new sendMail();

$mail->mailsend('agrawalakriti05@gmail.com','test','test mail');

echo "mail sent";

?>