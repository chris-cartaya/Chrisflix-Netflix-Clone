<?php
    if (isset($_POST["submitButton"])) {
        echo "Form was submitted<br>";
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

                <input type="text" name="userName" placeholder="Username">

                <input type="email" name="email" placeholder="Email">

                <input type="email" name="email2" placeholder="Confirm email">

                <input type="password" name="password" placeholder="Password">

                <input type="password" name="password2" placeholder="Confirm password">

                <input type="submit" name="submitButton" value="SUBMIT">

            </form>

        </div>
    </div>

</body>
</html>