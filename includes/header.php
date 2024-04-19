<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");

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
</head>
<body>
    <div class="wrapper">
    

