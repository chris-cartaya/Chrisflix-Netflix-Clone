<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$detailsMessage = "";

if (isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);

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
?>
<div class="settingsContainer column">

    <div class="formSection">
        <form method="POST">
            <h2>Update User Details</h2>

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

            <input type="submit" name="savePasswordButton" value="Save">
        </form>
    </div>

</div>
