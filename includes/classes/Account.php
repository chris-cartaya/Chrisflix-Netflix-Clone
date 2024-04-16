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

    public function register($firstName, $lastName, $username, 
                             $email, $email2, $password, $password2) {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUserName($username);
        $this->validateEmails($email, $email2);
        $this->validatePasswords($password, $password2);

        if (empty($this->errorArr)) {
            return $this->insertUserDetails($firstName, $lastName, $username, 
                                            $email, $password);
        }

        return false;
    }

    private function insertUserDetails($firstName, $lastName, $username, 
                                       $email, $password) {
        $password = hash("sha512", $password);
        
        $sql = "INSERT INTO 
                    users (firstName, lastName, username, email, password)
                VALUES (:firstName, :lastName, :username, :email, :password)";
        
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        return $stmt->execute();

    }

    private function validateFirstName($firstName) {
        if (strlen($firstName) < Constants::NAME_MIN_CHARS || 
            strlen($firstName) > Constants::NAME_MAX_CHARS) {
            array_push($this->errorArr, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lastName) {
        if (strlen($lastName) < Constants::NAME_MIN_CHARS || 
            strlen($lastName) > Constants::NAME_MAX_CHARS) {
            array_push($this->errorArr, Constants::$lastNameCharacters);
        }
    }

    private function validateUserName($username) {
        if (strlen($username) < Constants::USERNAME_MIN_CHARS || 
            strlen($username) > Constants::USERNAME_MAX_CHARS) {
            array_push($this->errorArr, Constants::$usernameCharacters);
            return;
        }

        $sql = "SELECT * 
                FROM users 
                WHERE username = :username;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            array_push($this->errorArr, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $email2) {
        if ($email != $email2) {
            array_push($this->errorArr, Constants::$emailsDoNotMatch);
            return;
        }

        // We only check one email because we know both emails are equal.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            array_push($this->errorArr, Constants::$emailInvalid);
            return;
        }

        $sql = "SELECT * 
                FROM users 
                WHERE email = :email;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            array_push($this->errorArr, Constants::$emailTaken);
        }
    }

    private function validatePasswords($password, $password2) {
        if ($password != $password2) {
            array_push($this->errorArr, Constants::$passwordsDoNotMatch);
            return;
        }

        if (strlen($password) < Constants::PASSWORD_MIN_CHARS || 
            strlen($password) > Constants::PASSWORD_MAX_CHARS) {
            array_push($this->errorArr, Constants::$passwordLength);
        }

    }

    public function getError($error) {
        if (in_array($error, $this->errorArr)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

}
?>