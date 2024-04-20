<?php
require_once("../includes/config.php");

if (isset($_POST["username"]) && isset($_POST["videoID"])) {

    $username = $_POST["username"];
    $videoID = $_POST["videoID"];

    $sql = "SELECT progress
            FROM video_progress
            WHERE username = :username AND videoID = :videoID";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
    $stmt->execute();
    
    echo $stmt->fetchColumn();

} else {
    echo "No videoID or username passed into file";
}
?>