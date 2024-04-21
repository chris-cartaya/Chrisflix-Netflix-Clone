<?php
class VideoProvider {

    public static function getUpNext(PDO $con, Video $currentVideo) {

        $entityId = $currentVideo->getEntityId();
        $videoId = $currentVideo->getId();
        $season = $currentVideo->getSeasonNumber();
        $episode = $currentVideo->getEpisodeNumber();

        // Select all videos which are of that entityId and is NOT the video 
        // the user is currently watching AND either:
        // 1) get a video from the current season with episodes greater than 
        //      the one the user is watching OR
        // 2) if there are no more episodes from that season, 
        //      get the next season
        $sql = "SELECT *
                FROM videos
                WHERE entityId = :entityId AND id != :videoId
                AND (
                    (season = :season AND episode > :episode) OR 
                    season > :season
                )
                ORDER BY season, episode ASC
                LIMIT 1";

        $stmt = $con->prepare($sql);
        
        $stmt->bindValue(":entityId", $entityId , PDO::PARAM_INT);
        $stmt->bindValue(":videoId", $videoId , PDO::PARAM_INT);
        $stmt->bindValue(":season", $season , PDO::PARAM_INT);
        $stmt->bindValue(":episode", $episode , PDO::PARAM_INT);
        
        $stmt->execute();

        // If there are no more episodes to watch, 
        // select a random season 1 episode 1 show or selects a movie (season=0)
        if ($stmt->rowCount() == 0) {
            $sql = "SELECT * 
                    FROM videos
                    WHERE season <= 1 AND episode <= 1 AND id != :videoId
                    ORDER BY views DESC
                    LIMIT 1";

            $stmt = $con->prepare($sql);
            $stmt->bindValue(":videoId", $videoId , PDO::PARAM_INT);
            $stmt->execute();
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return new Video($con, $row);
    }

}
?>