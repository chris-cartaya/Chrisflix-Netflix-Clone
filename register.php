<?php
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {
    echo "Form was submitted<br>";

    $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
    $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
    $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);
    
    echo "firstName: "; var_dump($firstName);   echo "<br>";
    echo "lastName: ";  var_dump($lastName);    echo "<br>";
    echo "username: ";  var_dump($username);    echo "<br>";
    echo "email: ";     var_dump($email);       echo "<br>";
    echo "email2: ";    var_dump($email2);      echo "<br>";
    echo "password: ";  var_dump($password);    echo "<br>";
    echo "password2: "; var_dump($password2);   echo "<br>";

    $success = $account->register($firstName, $lastName, $username, $email, 
                                  $email2, $password, $password2);
    
    if ($success) {
        // Store session variables --- do later.
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Chrisflix</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
</head>
<body>
    
    <div class="signInContainer">
        <div class="column">

            <div class="header">
                <img src="assets/images/chrisflix-logo.png" alt="Chrisflix logo" title="Logo">
                <h1>Sign Up</h1>
                <span>to continue to Chrisflix</span>
            </div>
        
            <form action="" method="POST">
                <!-- add required to all inputs later -->
                <?= $account->getError(Constants::$firstNameCharacters); ?>
                <input 
                    type="text" 
                    name="firstName" 
                    placeholder="First name" 
                    required
                >

                <?= $account->getError(Constants::$lastNameCharacters); ?>
                <input 
                    type="text" 
                    name="lastName" 
                    placeholder="Last name" 
                    required
                >

                <?= $account->getError(Constants::$usernameCharacters); ?>
                <?= $account->getError(Constants::$usernameTaken); ?>
                <input 
                    type="text" 
                    name="username" 
                    placeholder="Username" 
                    required
                >

                <?= $account->getError(Constants::$emailsDoNotMatch); ?>
                <?= $account->getError(Constants::$emailInvalid); ?>
                <?= $account->getError(Constants::$emailTaken); ?>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    required
                >
                
                <input 
                    type="email" 
                    name="email2" 
                    placeholder="Confirm email" 
                    required
                >
                
                <?= $account->getError(Constants::$passwordsDoNotMatch); ?>
                <?= $account->getError(Constants::$passwordLength); ?>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password"
                    required
                >

                <input 
                    type="password" 
                    name="password2" 
                    placeholder="Confirm password"
                    required
                >

                <input type="submit" name="submitButton" value="SUBMIT">

            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>

        </div>
    </div>

</body>
</html>