<?php
require_once("../includes/config.php");

if (isset($_POST["username"]) && 
    isset($_POST["videoID"]) && 
    isset($_POST["progress"])
) {

    $username = $_POST["username"];
    $videoID = $_POST["videoID"];
    $progress = $_POST["progress"];

    $sql = "UPDATE video_progress
            SET progress = :progress, 
                dateModified = NOW()
            WHERE username = :username AND videoId = :videoID";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
    $stmt->bindValue(":progress", $progress, PDO::PARAM_INT);
    $stmt->execute();

} else {
    echo "No videoID or username passed into file";
}
?>