<?php
    echo "<pre>";
    print_r($_FILES);
    error_reporting(9);

    if($_REQUEST['action'] == 'submit') 
    {
        $ch = curl_init();
        $filePath = $_FILES['fileupload']['tmp_name'];
        $fileName = $_FILES['fileupload']['name'];
        $data = array('name' => 'UBLFeedBack', 'file' => "@$filePath", 'fileName' =>$fileName);             
        curl_setopt($ch, CURLOPT_URL, 'https://sns.m3tech.com.pk/ublfeedback/api/business/upload.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_exec($ch);
        curl_close($ch);
    }
?>

<form name="file_up" action="upload.php" method="POST" enctype="multipart/form-data">
    Upload your file here
    <input type="file" name="fileupload" id="fileupload"/>
    <input type="submit" name="action" value="submit"/>
</form>