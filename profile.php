<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);
$user = new User($con, $userLoggedIn);

$detailsMessage = "";
$passwordMessage = "";

// For updating user details
if (isset($_POST["saveDetailsButton"])) {

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if ($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        
        $detailsMessage = 
            "<div class='alertSuccess'>
                Details updated successfully!
            </div>";

    } else {

        $errorMessage = $account->getFirstError();

        $detailsMessage = 
            "<div class='alertError'>
                $errorMessage
            </div>";
    }
}

// For updating password
if (isset($_POST["savePasswordButton"])) {

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if ($account->updatePassword($oldPassword, $newPassword, 
                                 $newPassword2, $userLoggedIn)
    ) {
        $passwordMessage = 
            "<div class='alertSuccess'>
                Password updated successfully!
            </div>";

    } else {

        $errorMessage = $account->getFirstError();

        $passwordMessage = 
            "<div class='alertError'>
                $errorMessage
            </div>";
    }
}
?>
<div class="settingsContainer column">

    <div class="formSection">
        <form method="POST">
            <h2>Update User Details</h2>

            <?php
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

            <div class="message">
                <?= $detailsMessage; ?>
            </div>

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
            
            <div class="message">
                <?= $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Save">
        </form>
    </div>

    <div class="formSection">
        <h2>Subscription Information</h2>

        <?php
            if ($user->getIsSubscribed()) {
                echo "<h3>You are subscribed!</h3>
                      <a href='cancel.php'>Cancel subscription</a>";
            } else {
                echo "<a href='subscribe.php'>Subscribe to Chrisflix</a>";
            }
        ?>

    </div>

</div>
