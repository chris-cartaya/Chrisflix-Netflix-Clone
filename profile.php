<?php
require_once("includes/header.php");
?>
<div class="settingsContainer column">

    <div class="formSection">
        <form method="POST">
            <h2>User details</h2>

            <?php
            $user = new User($con, $userLoggedIn);

            $firstName = $_POST["firstName"] ?? $user->getFirstName();
            $lastName = $_POST["lastName"] ?? $user->getLastName();
            $email = $_POST["email"] ?? $user->getEmail();
            ?>

            <input 
                type="text" name="firstName" placeholder="First name"
                value="<?= $firstName; ?>"
            >

            <input 
                type="text" name="lastName" placeholder="Last name"
                value="<?= $lastName; ?>"
            >

            <input 
                type="email" name="email" placeholder="Email"
                value="<?= $email; ?>"
            >

            <input type="submit" name="saveDetailsButton" value="Save">
        </form>
    </div>

    <div class="formSection">
        <form method="POST">
            <h2>Update Password</h2>

            <input type="password" name="oldPassword" 
                   placeholder="Old password">

            <input type="password" name="newPassword" 
                   placeholder="New password">

            <input type="password" name="newPassword2" 
                   placeholder="Confirm new password">

            <input type="submit" name="savePasswordButton" value="Save">
        </form>
    </div>

</div>
