<?php
class Constants {
    const NAME_MIN_CHARS = 2;
    const NAME_MAX_CHARS = 25;

    const USERNAME_MIN_CHARS = 5;
    const USERNAME_MAX_CHARS = 25;

    public static $firstNameCharacters = "Your first name must be between " . self::NAME_MIN_CHARS . " and " . 
    self::NAME_MAX_CHARS . " characters";

    public static $lastNameCharacters = "Your last name must be between " . self::NAME_MIN_CHARS . " and " . 
    self::NAME_MAX_CHARS . " characters";

    public static $usernameCharacters = "Username must be between " . self::USERNAME_MIN_CHARS . " and " . 
    self::USERNAME_MAX_CHARS . " characters";
}
?>