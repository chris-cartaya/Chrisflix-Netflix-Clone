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
     * @param array|int $input An array of data to create entity or an integer 
     * ID to fetch entity.
     */
    public function __construct(PDO $con, array|int $input) {
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

        $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }
}
?>