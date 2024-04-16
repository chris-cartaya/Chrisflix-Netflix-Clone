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

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
    }

    private function validateFirstName($fname) {
        if (strlen($fname) < 2 || strlen($fname) > 25) {
            array_push($this->errorArr, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lname) {
        if (strlen($fname) < 2 || strlen($fname) > 25) {
            array_push($this->errorArr, Constants::$lastNameCharacters);
        }
    }

    public function getError($error) {
        if (in_array($error, $this->errorArr)) {
            return $error;
        }
    }

}
?>