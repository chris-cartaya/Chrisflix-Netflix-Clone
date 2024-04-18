<?php
class PreviewProvider {

    /**
     * Connection to the database
     * @var object PDO object 
     */
    private $con;

    private $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createPreviewVideo($entity) {
        if ($entity == null) {
            // create a random entity
            $entity = $this->getRandomEntity();
        }
    }

    private function getRandomEntity() {
        $sql = "SELECT * 
                FROM entities 
                ORDER BY RAND() 
                LIMIT 1;";
        
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["name"];
    }

}
?>