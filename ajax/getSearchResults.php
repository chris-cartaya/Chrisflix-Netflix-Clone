<?php
require_once("../includes/config.php");
require_once("../includes/classes/SearchResultsProvider.php");

if (isset($_POST["term"]) && isset($_POST["username"])) {

    // get search results
    $username = $_POST["username"];
    $searchTerm = $_POST["term"];

    $searchResults = new SearchResultsProvider($con, $username);
    echo $searchResults->getResults($searchTerm);

} else {
    echo "No term or username passed into file";
}
?>