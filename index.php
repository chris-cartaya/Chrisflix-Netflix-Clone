<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");

$userLoggedIn = $_SESSION["userLoggedIn"];

if (!isset($userLoggedIn)) {
    header("Location: register.php");
}
echo "IN INDEX.PHP FILE!<br>";


$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo();
?>
