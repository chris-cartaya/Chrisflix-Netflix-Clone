<?php
class Video {
    
    /**
     * Connection to the database
     * @var PDO The PDO object representing the database connection.
     */
    private PDO $con;

    /**
     * Data array representing entity attributes or the entity ID.
     * @var array sqlData
     */
    private $sqlData;

    /**
     * What entity does the video correspond to
     * @var Entity
     */
    private $entity;

    /**
     * Entity constructor.
     * 
     * Sets the PDO object to connect to the database and initializes the 
     * entity data. 
     * If an array is provided, it represents entity data. If an integer is 
     * provided, it represents the entity ID to fetch data from the database.
     * 
     * @param PDO $con The PDO object representing the database connection.
     * @param array|string $input An array of data to create entity or a
     * string integer ID to fetch entity.
     */
    public function __construct(PDO $con, array|string $input) {
        $this->con = $con;

        if (is_array($input)) {
            $this->sqlData = $input;
        } else {
            $sql = "SELECT * 
                    FROM videos 
                    WHERE id = :id";
        
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":id", $input, PDO::PARAM_INT);
            $stmt->execute();

            $this->sqlData = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }

    public function getId() {
        return $this->sqlData["id"];
    }
    
    public function getTitle() {
        return $this->sqlData["title"];
    }
    
    public function getDescription() {
        return $this->sqlData["description"];
    }
    
    public function getFilePath() {
        return $this->sqlData["filePath"];
    }
    
    public function getThumbnail() {
        return $this->entity->getThumbnail();
    }

    public function getSeasonNumber() {
        return $this->sqlData["season"];
    }
    
    public function getEpisodeNumber() {
        return $this->sqlData["episode"];
    }

    public function getEntityId() {
        return $this->sqlData["entityId"];
    }

    public function incrementViews() {
        $sql = "UPDATE videos
                SET views = views + 1
                WHERE id = :id";
        
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getSeasonAndEpisode() {
        if ($this->isMovie()) {
            return;
        }
        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        return "Season $season, Episode $episode";
    }

    public function isMovie(): bool {
        return $this->sqlData["isMovie"] == 1;
    }

    // If user has started watching the video, then there will be a row in the 
    // video_progress table in the database with that username and videoID. 
    // If a row is returned, then the user has started watching that video 
    // already, so it IS in progress, and function returns true. 
    // If the query returns no rows, then the user has not started watching 
    // that video, so it is NOT in progress, and function returns false .
    public function isInProgress(string $username): bool {
        $sql = "SELECT *
                FROM video_progress
                WHERE username = :username AND videoID = :videoID";
        
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":videoID", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() != 0;
    }
    
}
?>