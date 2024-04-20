<?php
class CategoryContainers {

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

    public function showAllCategories() {

        $stmt = $this->con->prepare("SELECT * FROM CATEGORIES");
        $stmt->execute();

        $html = "<div class='previewCategories'>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= $row["name"] . "<br>";
        }

        return $html . "</div>";
    }

}
?>