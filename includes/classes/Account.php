<?php
class Account {
    
    /**
     * Connection to the database
     * @var object PDO object 
     */
    private $con;

    /**
     * Holds all error messages
     * @var array Error array
     */
    private $errorArr = array();
    
    public function __construct($con) {
        $this->con = $con;
    }

    public function validateFirstName($fname) {
        if (strlen($fname) < 2 || strlen($fname) > 25) {
            array_push($this->errorArr, Constants::$firstNameCharacters);
        }
    }

    public function getError($error) {
        if (in_array($error, $this->errorArr)) {
            return $error;
        }
    }

}
?>