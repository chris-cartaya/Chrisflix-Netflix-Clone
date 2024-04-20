<?php
require_once("../includes/config.php");

if (isset($_POST["username"]) && isset($_POST["videoID"])) {

    $username = $_POST["username"];
    $videoID = $_POST["videoID"];

    $sql = "UPDATE video_progress
            SET finished = 1,
                progress = 0 
            WHERE username = :username AND videoID = :videoID";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
    $stmt->execute();

} else {
    echo "No videoID or username passed into file";
}
?>