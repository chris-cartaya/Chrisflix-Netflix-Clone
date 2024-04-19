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

    public function __construct($con, string $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createPreviewVideo($entity) {
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
        
                <img src='$thumbnail' alt='Video poster of $entityName'
                     class='previewImage' hidden>

                <video autoplay muted class='previewVideo'>
                    <source src='$preview' type='video/mp4'>
                </video>

                <div class='previewOverlay'>
                    
                    <div class='mainDetails'>
                        <h1>$entityName</h1>

                        <div class='buttons'>
                            <button>
                                <i class='fa-solid fa-play'></i> Play
                            </button>
                            <button>
                                <i class='fa-solid fa-volume-xmark'></i>
                            </button>
                        </div>

                    </div>

                </div>

            </div>";

    }

    private function getRandomEntity() {
        $sql = "SELECT * 
                FROM entities 
                ORDER BY RAND() 
                LIMIT 1;";
        
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Entity($this->con, $row);
    }

}
?>