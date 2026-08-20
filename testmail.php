<?php
# phpinfo();
$to      = 'hummam@m3tech.com.pk';
$subject = 'the subject LIVE 1:54';
$message = 'hello LIVE Server';
$headers = 'From: services.life@igi.com.pk' . "\r\n" .
    'Reply-To: services.life@igi.com.pk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

echo mail($to, $subject, $message, $headers);

echo mail("hummam@m3tech.com.pk","My subject 4:43","testing LIVE Server" ,$headers);

echo "email sent";
 ?>
