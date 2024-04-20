<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");

$userLoggedIn = $_SESSION["userLoggedIn"];

if (!isset($userLoggedIn)) {
    header("Location: register.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Chrisflix</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/01aa4a6840.js" 
            crossorigin="anonymous"></script>
    
    <script src="assets/js/script.js"></script>
</head>

<body>
    <div class="wrapper">
    

