<?php

// Waits until all PHP is executed before outputting to page.
ob_start(); // Turns on output buffering. 

// Used to tell if a user is logged in or not.
session_start();

date_default_timezone_set("America/New_York");
?>