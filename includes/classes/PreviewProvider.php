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

        echo $id . "<br>";
        echo $entityName . "<br>";
        echo $thumbnail . "<br>";
        echo "<img src='$thumbnail'><br>";
        echo $preview . "<br>";

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