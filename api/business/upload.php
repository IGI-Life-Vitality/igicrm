<?php
    echo "<pre>";
    print_r($_FILES);
    move_uploaded_file($_FILES["fileupload"]["tmp_name"], "../files/" . $_FILES["fileupload"]["name"]);
?>
