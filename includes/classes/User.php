<?php
class User {

    /**
     * Connection to the database
     * @var PDO The PDO object representing the database connection.
     */
    private PDO $con;

    /**
     * Data array representing entity attributes or the entity ID.
     * @var array sqlData
     */
    private array $sqlData;


    public function __construct(PDO $con, string $username) {
        $this->con = $con;

        $sql = "SELECT *
                FROM users
                WHERE username = :username";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $this->sqlData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getFirstName(): string {
        return $this->sqlData["firstName"];
    }

    public function getLastName(): string {
        return $this->sqlData["lastName"];
    }

    public function getEmail(): string {
        return $this->sqlData["email"];
    }

    public function getIsSubscribed(): string {
        // return $this->sqlData["isSubscribed"];
        return true;
    }


}
?>