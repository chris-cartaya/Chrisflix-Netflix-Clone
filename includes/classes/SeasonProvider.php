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

            // get video html

            $seasonsHTML .= 
                "<div class='season'>
                    <h3>Season $seasonNumber</h3>
                </div>";

        }

        return $seasonsHTML;
    }

    private function createVideoSquare($video) {
        $id = $video->getId();
        $videoName = $video->getName();
        $thumbnail = $video->getThumbnail();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();
    }

}
?>