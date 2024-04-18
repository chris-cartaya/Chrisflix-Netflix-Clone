<?php
class PreviewProvider {

    /**
     * Connection to the database
     * @var object PDO object 
     */
    private $con;

    private $username;

    public function __constructor($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function createPreviewVideo() {
        echo "createPreviewVideo() function runs<br>";
    }
}
?>