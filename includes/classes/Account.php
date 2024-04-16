<?php
class Account {
    
    /**
     * Connection to the database
     * @var object PDO object 
     */
    private $con;
    
    public function __construct($con) {
        $this->con = $con;
    }

}
?>