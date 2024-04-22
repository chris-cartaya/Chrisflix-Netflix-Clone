<?php
/**
 * Represents an user account management system.
 */
class Account {
    
    /**
     * Connection to the database
     * @var PDO The PDO object representing the database connection.
     */
    private PDO $con;

    /**
     * Holds all error messages
     * @var array Error array
     */
    private array $errorArr = [];
    
    /**
     * Account constructor.
     * 
     * @param PDO $con The PDO object representing the database connection.
     */
    public function __construct(PDO $con) {
        $this->con = $con;
    }

    /**
     * Registers a new user account.
     * 
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $username The username of the user.
     * @param string $email The email address of the user.
     * @param string $email2 The confirmation email address of the user.
     * @param string $password The password of the user.
     * @param string $password2 The confirmation password of the user.
     * 
     * @return bool True if registration is successful, false otherwise.
     */
    public function register(
        string $firstName, string $lastName, string $username, 
        string $email, string $email2, string $password, string $password2
    ): bool {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUserName($username);
        $this->validateEmails($email, $email2);
        $this->validatePasswords($password, $password2);

        if (!empty($this->errorArr)) {
            return false;
        }

        return $this->insertUserDetails(
            $firstName, $lastName, $username, $email, $password
        );
    }

    /**
     * Logs in the user.
     * 
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * 
     * @return bool True if login is successful, false otherwise.
     */
    public function login(string $username, string $password): bool {
        $password = hash("sha512", $password);

        $sql = "SELECT *
                FROM users
                WHERE username = :username AND password = :password";
        
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArr, Constants::$loginFailed);
        return false;
    }

    /**
     * Inserts user details into the database.
     * 
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param string $username The username of the user.
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     * 
     * @return bool True if insertion is successful, false otherwise.
     */
    private function insertUserDetails(
        string $firstName, string $lastName, string $username, 
        string $email, string $password
    ): bool {
        $password = hash("sha512", $password);
        
        $sql = "INSERT INTO users 
                    (firstName, lastName, username, email, password)
                VALUES 
                    (:firstName, :lastName, :username, :email, :password)";
        
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        return $stmt->execute();

    }


    // Returns true if successfully updated user details; false otherwise
    public function updateDetails(
        string $firstName, string $lastName, string $email, string $username
    ): bool {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateNewEmail($email, $username);

        if (!empty($this->errorArr)) {
            return false;
        }

        $sql = "UPDATE users
                SET firstName = :firstName, lastName = :lastName, email = :email
                WHERE username = :username";
        
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(":firstName", $firstName, PDO::PARAM_STR);
        $stmt->bindValue(":lastName", $lastName, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        return $stmt->execute();
    }


    // Returns true if successfully updated password; false otherwise
    public function updatePassword(
        string $oldPassword, string $newPassword, 
        string $newPassword2, string $username
    ): bool {
        $this->validateOldPassword($oldPassword, $username);
        $this->validatePasswords($newPassword, $newPassword2);

        if (!empty($this->errorArr)) {
            return false;
        }

        $sql = "UPDATE users
                SET password = :password
                WHERE username = :username";
        
        $stmt = $this->con->prepare($sql);

        $password = hash("sha512", $newPassword);

        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        return $stmt->execute();
    }

    
    public function validateOldPassword(string $oldPassword, string $username) {
        $password = hash("sha512", $oldPassword);

        $sql = "SELECT *
                FROM users
                WHERE username = :username AND password = :password";
        
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            array_push($this->errorArr, Constants::$passwordIncorrect);
        }
    }


    /**
     * Validates the first name of the user.
     * 
     * @param string $firstName The first name to validate.
     * 
     * @return void
     */
    private function validateFirstName(string $firstName): void {
        if (strlen($firstName) < Constants::NAME_MIN_CHARS || 
            strlen($firstName) > Constants::NAME_MAX_CHARS) {
            array_push($this->errorArr, Constants::$firstNameCharacters);
        }
    }

    /**
     * Validates the last name of the user.
     * 
     * @param string $lastName The last name to validate.
     * 
     * @return void
     */
    private function validateLastName(string $lastName): void {
        if (strlen($lastName) < Constants::NAME_MIN_CHARS || 
            strlen($lastName) > Constants::NAME_MAX_CHARS) {
            array_push($this->errorArr, Constants::$lastNameCharacters);
        }
    }

    /**
     * Validates the username of the user.
     * Checks if the username meets length requirements and if it is already 
     * taken.
     * 
     * @param string $username The username to validate.
     * 
     * @return void
     */
    private function validateUserName(string $username): void {
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

    /**
     * Validates the email addresses of the user.
     * Checks if the emails match and if they are valid.
     * 
     * @param string $email The primary email address.
     * @param string $email2 The confirmation email address.
     * 
     * @return void
     */
    private function validateEmails(string $email, string $email2): void {
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


    /**
     * Validates the new email address of the user.
     * Checks if any user has this same email.
     * 
     * @param string $email 
     * @param string $username 
     * 
     * @return void
     */
    private function validateNewEmail(string $email, string $username): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            array_push($this->errorArr, Constants::$emailInvalid);
            return;
        }

        $sql = "SELECT * 
                FROM users 
                WHERE email = :email
                AND username != :username";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            array_push($this->errorArr, Constants::$emailTaken);
        }
    }


    /**
     * Validates the passwords of the user.
     * Checks if the passwords match and if they meet length requirements.
     * 
     * @param string $password The password.
     * @param string $password2 The confirmation password.
     * 
     * @return void
     */
    private function validatePasswords(
        string $password, string $password2
    ): void {
        if ($password != $password2) {
            array_push($this->errorArr, Constants::$passwordsDoNotMatch);
            return;
        }

        if (strlen($password) < Constants::PASSWORD_MIN_CHARS || 
            strlen($password) > Constants::PASSWORD_MAX_CHARS) {
            array_push($this->errorArr, Constants::$passwordLength);
        }

    }

    /**
     * Gets the error message based on error code.
     * 
     * @param string $error The error code.
     * 
     * @return string|null The error message or null if error not found.
     */
    public function getError(string $error) {
        if (in_array($error, $this->errorArr)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    // Return the first error in the error array.
    public function getFirstError() {
        if (!empty($this->errorArr)) {
            return $this->errorArr[0];
        }
    }

}
?>