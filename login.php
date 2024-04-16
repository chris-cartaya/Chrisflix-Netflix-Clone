<?php
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if (isset($_POST["submitButton"])) {
    echo "Form was submitted<br>";

    $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
    
    echo "username: ";  var_dump($username);    echo "<br>";
    echo "password: ";  var_dump($password);    echo "<br>";

    $success = $account->login($username, $password);
    
    if ($success) {
        $_SESSION["userLoggedIn"] = $username;
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
                <h1>Sign In</h1>
                <span>to continue to Chrisflix</span>
            </div>
        
            <form action="" method="POST">
                <!-- add required to all inputs later -->
                <?= $account->getError(Constants::$loginFailed); ?>

                <input type="text" name="username" 
                       placeholder="Username" required>

                <input type="password" name="password" 
                       placeholder="Password" required>

                <input type="submit" name="submitButton" value="SUBMIT">

            </form>

            <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>

        </div>
    </div>

</body>
</html>