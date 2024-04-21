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

    public function __construct(PDO $con, string $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function showAllCategories(): string {

        $stmt = $this->con->prepare("SELECT * FROM categories");
        $stmt->execute();

        $html = "<div class='previewCategories'>";

        // $row will continue iterating for each row from the query.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHTML($row, null, true, true);
        }

        return $html . "</div>";
    }


    public function showTVShowCategories(): string {

        $stmt = $this->con->prepare("SELECT * FROM categories");
        $stmt->execute();

        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";

        // $row will continue iterating for each row from the query.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHTML($row, null, true, false);
        }

        return $html . "</div>";
    }


    public function showMovieCategories(): string {

        $stmt = $this->con->prepare("SELECT * FROM categories");
        $stmt->execute();

        $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";

        // $row will continue iterating for each row from the query.
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHTML($row, null, false, true);
        }

        return $html . "</div>";
    }


    // Shows all entities that below to a certain category
    public function showCategory(int $categoryId, ?string $title = null) {
        
        $sql = "SELECT * 
                FROM categories 
                WHERE id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        $html = "<div class='previewCategories noScroll'>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHTML($row, $title, true, true);
        }

        return $html . "</div>";
    }

    // This function will get all the entities.
    // $sqlData will contain each row of the Categories table in the database
    // and $sqlData will contain id and category name.
    // $title will be the title of the category. If null, we use the category 
    // name. If we do specify a title, then we will use it in place of where 
    // the category name would go.
    // $tvShows and $movies are both booleans (T/F) on whether or not we want 
    // to include tv shows and/or movies from the database. Home page will want
    // both tv shows and movies, and there will be separate 'tabs' for movies 
    // and tv shows.
    private function getCategoryHTML(
        array $sqlData, ?string $title, bool $tvShows, bool $movies
    ) {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;
        
        if ($tvShows && $movies) {
            $entities = EntityProvider::getEntities(
                $this->con, $categoryId, 30
            );
        } 
        else if ($tvShows) {
            $entities = EntityProvider::getTVShowEntities(
                $this->con, $categoryId, 30
            );
        } 
        else {
            $entities = EntityProvider::getMovieEntities(
                $this->con, $categoryId, 30
            );
        }

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
                
                <a href='category.php?id=$categoryId'><h3>$title</h3></a>

                <div class='entities'>
                    $entitiesHTML;
                </div>

            </div>";
    }

}
?>