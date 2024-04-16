<?php

// Waits until all PHP is executed before outputting to page.
ob_start(); // Turns on output buffering. 

// Used to tell if a user is logged in or not.
session_start();

date_default_timezone_set("America/New_York");


try {
    $dsn = "mysql:dbname=chrisflix;host=localhost";
    $db_user = "root";
    $db_password = "";

    $con = new PDO($dsn, $db_user, $db_password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

} catch(PDOException $e) {
    exit("Connection failed: {$e->getMessage()}");
}

?>