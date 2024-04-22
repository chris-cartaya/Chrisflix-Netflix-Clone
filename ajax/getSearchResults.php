<?php
require_once("../includes/config.php");
require_once("../includes/classes/SearchResultsProvider.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");
require_once("../includes/classes/PreviewProvider.php");

if (isset($_POST["term"]) && isset($_POST["username"])) {

    $username = $_POST["username"];
    $searchTerm = $_POST["term"];

    $searchResults = new SearchResultsProvider($con, $username);
    echo $searchResults->getResults($searchTerm);

} else {
    echo "No term or username passed into file";
}
?>