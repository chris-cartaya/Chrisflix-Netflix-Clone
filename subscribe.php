<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);
$user = new User($con, $userLoggedIn);

// Check if the user is already subscribed
if ($user->getIsSubscribed()) {

    $subscribeMessage = 
        "<div class='alertError'>
            You are already subscribed!
        </div>";

} else {
    $user->setIsSubscribed(1);

    $subscribeMessage = 
        "<div class='alertSuccess'>
            Successfully subscribed!
        </div>";
}
?>
<div class="settingsContainer column">
    <div class="formSection">
        <?= $subscribeMessage ?>
        <a href="profile.php">Back to Profile Page</a>
    </div>
</div>