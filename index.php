<?php
require_once("includes/header.php");

echo "IN INDEX.PHP FILE!<br>";

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);
?>
