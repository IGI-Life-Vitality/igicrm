<?php

require_once("includes/config.php");

include(CLASSES_PATH.DS.'complaint.php');

$objComplaint = new Complaint();

echo $objComplaint->GetEndDate(1);