<?php
/**
 * Represents an video entity in the database.
 */
class Entity {

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
     * Entity constructor.
     * 
     * Sets the PDO object to connect to the database and initializes the 
     * entity data. 
     * If an array is provided, it represents entity data. If an integer is 
     * provided, it represents the entity ID to fetch data from the database.
     * 
     * @param PDO $con The PDO object representing the database connection.
     * @param array|string $input An array of data to create entity or a string
     * integer ID to fetch entity.
     */
    public function __construct(PDO $con, array|string $input) {
        $this->con = $con;

        if (is_array($input)) {
            $this->sqlData = $input;
        } else {
            $sql = "SELECT * 
                    FROM entities 
                    WHERE id = :id";
        
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(":id", $input, PDO::PARAM_INT);
            $stmt->execute();

            $this->sqlData = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getName() {
        return $this->sqlData["name"];
    }

    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }

    public function getPreview() {
        return $this->sqlData["preview"];
    
    }
    public function getCategoryId() {
        return $this->sqlData["categoryId"];
    }

    public function getSeasons() {
        $sql = "SELECT *
                FROM videos
                WHERE entityId = :id AND isMovie = 0
                ORDER BY season, episode ASC";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $this->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $seasons = [];
        $videos = [];
        $currentSeason = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            if ($currentSeason != null && $currentSeason != $row["season"]) {
                $seasons[] = new Season($currentSeason, $videos);
                $videos = [];
            }

            $currentSeason = $row["season"];
            $videos[] = new Video($this->con, $row);

        }

        if (sizeof($videos) != 0) {
            $seasons[] = new Season($currentSeason, $videos);
        }

        return $seasons;
    }

}
?>