<?php
require("business/config.php");

function generate_hash($data)
{
    return hash_hmac('sha256', $data, SECRET_KEY);
}

function verify_hash($data, $hash)
{
    return hash_equals(generate_hash($data), $hash);
}



// $input = "Hello, World!";
// $hashValue = hash('sha256', $input);

// $secretkey = "Hello, World";
// $secretkeyhash = hash('sha256', $secretkey);


// if ($hashValue == $secretkeyhash) {

//     echo 'matched';
// } else {

//     echo 'not matched';
// }
