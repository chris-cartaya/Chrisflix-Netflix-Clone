<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");

if (isset($_POST["submitButton"])) {
    echo "Form was submitted<br>";

    $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
    $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
    $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);
    
    echo("firstName: {$firstName}<br>");
    echo("lastName: {$lastName}<br>");
    echo("username: {$username}<br>");
    echo("email: {$email}<br>");
    echo("email2: {$email2}<br>");
    echo("password: {$password}<br>");
    echo("password2: {$password2}<br>");
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
                <input type="text" name="firstName" placeholder="First name">

                <input type="text" name="lastName" placeholder="Last name">

                <input type="text" name="username" placeholder="Username">

                <input type="email" name="email" placeholder="Email">

                <input type="email" name="email2" placeholder="Confirm email">

                <input type="password" name="password" placeholder="Password">

                <input type="password" name="password2" placeholder="Confirm password">

                <input type="submit" name="submitButton" value="SUBMIT">

            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>

        </div>
    </div>

</body>
</html>