<?php
class EntityProvider {

    public static function getEntities(PDO $con, ?int $categoryId, int $limit) {
        
        $sql = "SELECT * FROM entities ";

        if ($categoryId != null) {
            $sql .= "WHERE categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";
        
        $stmt = $con->prepare($sql);

        if ($categoryId != null) {
            $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        }

        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row);
        }
        
        return $result;
    }


    public static function getTVShowEntities(
        PDO $con, ?int $categoryId, int $limit
    ) {
        
        $sql = "SELECT DISTINCT (entities.id) 
                FROM entities
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 0 ";

        if ($categoryId != null) {
            $sql .= "AND categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";
        
        $stmt = $con->prepare($sql);

        if ($categoryId != null) {
            $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        }

        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);
        }
        
        return $result;
    }


    public static function getMoviesEntities(
        PDO $con, ?int $categoryId, int $limit
    ) {
        
        $sql = "SELECT DISTINCT (entities.id) 
                FROM entities
                INNER JOIN videos
                ON entities.id = videos.entityId
                WHERE videos.isMovie = 1 ";

        if ($categoryId != null) {
            $sql .= "AND categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";
        
        $stmt = $con->prepare($sql);

        if ($categoryId != null) {
            $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        }

        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Entity($con, $row["id"]);
        }
        
        return $result;
    }

}
?>