<?php
require_once("../includes/config.php");

if (isset($_POST["term"]) && isset($_POST["username"])) {

    $username = $_POST["username"];

    echo $_POST["term"] . " FROM getSearchResults.php!";

} else {
    echo "No term or username passed into file";
}
?>