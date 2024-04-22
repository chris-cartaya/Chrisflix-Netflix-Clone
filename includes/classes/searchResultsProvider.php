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

        $html = "<div class='previewCategories noScroll'>";
        
        $html .= $this->getResultHTML($entities);

        return $html . "</div>";
    }


    private function getResultHTML(array $entities) {
        if (sizeof($entities) == 0) {
            return;
        }

        $entitiesHTML = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);

        foreach ($entities as $entity) {
            $entitiesHTML .= 
                $previewProvider->createEntityPreviewSquare($entity);
        }

        return 
            "<div class='category'>
                <div class='entities'>
                    $entitiesHTML;
                </div>
            </div>";
    }

}
?>