<?php
class searchResultsProvider {

    /**
     * Connection to the database
     * @var PDO The PDO object representing the database connection.
     */
    private PDO $con;

    /**
     * The user logged in
     * @var string username
     */
    private string $username;

    
    public function __construct(PDO $con, string $username) {
        $this->con = $con;
        $this->username = $username;
    }


    public function getResults(string $searchText) {
        $entities = EntityProvider::getSearchEntities($this->con, $searchText);
    }

}
?>