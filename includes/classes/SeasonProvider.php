<?php
class SeasonProvider {

    /**
     * Connection to the database
     * @var PDO The PDO object representing the database connection.
     */
    private PDO $con;

    /**
     * The user logged in
     * @var string username
     */
    private $username;

    public function __construct(PDO $con, string $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function create($entity) {
        $seasons = $entity->getSeasons();

        if (sizeof($seasons) == 0) {
            return;
        }

        $seasonsHTML = "";
        foreach ($seasons as $season) {
            $seasonNumber = $season->getSeasonNumber();

            $videosHTML = "";
            foreach ($season->getVideos() as $video) {
                $videosHTML .= $this->createVideoSquare($video);
            }

            $seasonsHTML .= 
                "<div class='season'>
                    <h3>Season $seasonNumber</h3>
                    <div class='videos'>
                        $videosHTML;
                    </div>
                </div>";
        }

        return $seasonsHTML;
    }

    private function createVideoSquare($video) {
        $id = $video->getId();
        $videoTitle = $video->getTitle();
        $thumbnail = $video->getThumbnail();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();

        return 
            "<a href='watch.php?id=$id'>
                <div class='episodeContainer'>
                    <div class='contents'>

                        <img src='$thumbnail' 
                             alt='Video thumbnail of $videoTitle'>
                        
                        <div class='videoInfo'>
                            <h4>$episodeNumber. $videoTitle</h4>
                            <span>$description</span>
                        </div>

                    </div>
                </div>
            </a>";
    }

}
?>