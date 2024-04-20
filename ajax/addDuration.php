<?php
require_once("../includes/config.php");

if (isset($_POST["username"]) && isset($_POST["videoID"])) {

    $username = $_POST["username"];
    $videoID = $_POST["videoID"];

    $sql = "SELECT *
            FROM video_progress
            WHERE username = :username AND videoID = :videoID";

    $stmt = $con->prepare($sql);
    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
    $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
    $stmt->execute();

    // If there are no rows in the table
    if ($stmt->rowCount() == 0) {

        $sql = "INSERT INTO video_progress (username, videoID)
                VALUES  (:username, :videoID)";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":videoID", $videoID, PDO::PARAM_INT);
        $stmt->execute();

    }

} else {
    echo "No videoID or username passed into file";
}
?>