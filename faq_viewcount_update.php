<?php
include("config.php");

$faqid = $_GET["faqid"];
$sql = "UPDATE tbl_faq SET viewcount = viewcount+1 WHERE faq_id = $faqid ";
$res = db_query($con, $sql);
?>