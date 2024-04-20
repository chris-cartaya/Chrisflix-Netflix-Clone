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

        $id = $entity->getId();
        $entityName = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $preview = $entity->getPreview();

        // TODO: ADD SUBTITLE

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

                        <div class='buttons'>
                            <button>
                                <i class='fa-solid fa-play'></i> Play
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
        $id = $entity->getId();
        $entityName = $entity->getName();
        $thumbnail = $entity->getThumbnail();

        return 
            "<a href='entity.php?id=$id'>
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