<?php

$subject = "test";
$html = "<p>test message</p>";

$email_address = "noman.mateen@m3tech.com.pk";
$headers = "From:" . $email_address;
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

echo mail("noman.khan330@gmail.com", $subject, $html, $headers);

/*if (mail("noman.mateen@bailssoft.com", $subject, $html, $headers))
{
    //echo "success";
}else{
    //echo "fail";
}*/
?>