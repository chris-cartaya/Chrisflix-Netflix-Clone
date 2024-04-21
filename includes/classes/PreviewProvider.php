<?php
class PreviewProvider {

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

    public function createPreviewVideo(?Entity $entity) {
        if ($entity == null) {
            $entity = $this->getRandomEntity();
        }

        $entityId = $entity->getId();
        $entityName = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $preview = $entity->getPreview();

        $videoID = VideoProvider::getEntityVideoForUser(
            $this->con, $entityId, $this->username
        );

        $video = new Video($this->con, $videoID);

        $inProgress = $video->isInProgress($this->username);
        $playButtonText = $inProgress ? "Continue watching" : "Play";

        $seasonEpisode = $video->getSeasonAndEpisode();
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        return 
            "<div class='previewContainer'>
        
                <img
                    src='$thumbnail' 
                    alt='Video poster of $entityName'
                    class='previewImage' 
                    hidden
                >

                <video 
                    autoplay 
                    muted 
                    class='previewVideo' 
                    onended='previewEnded()'
                >
                    <source src='$preview' type='video/mp4'>
                </video>

                <div class='previewOverlay'>
                    
                    <div class='mainDetails'>
                        <h1>$entityName</h1>
                        $subHeading
                        <div class='buttons'>
                            <button onclick='watchVideo($videoID)'>
                                <i class='fa-solid fa-play'></i> $playButtonText
                            </button>

                            <button onclick='volumeToggle(this)'>
                                <i class='fa-solid fa-volume-xmark'></i>
                            </button>
                        </div>

                    </div>

                </div>

            </div>";

    }

    public function createEntityPreviewSquare($entity) {
        $entityId = $entity->getId();
        $entityName = $entity->getName();
        $thumbnail = $entity->getThumbnail();

        return 
            "<a href='entity.php?id=$entityId'>
                <div class='previewContainer small'>
                    <img 
                        src='$thumbnail' 
                        alt='Thumbnail poster of $entityName' 
                        title='$entityName'
                    >
                </div>
            </a>";
    }


    private function getRandomEntity() {
        $entity = EntityProvider::getEntities($this->con, null, 1);
        return $entity[0];
    }

}
?>