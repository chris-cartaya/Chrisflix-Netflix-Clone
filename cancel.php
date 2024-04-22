<?php
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);
$user = new User($con, $userLoggedIn);

if ($user->getIsSubscribed()) {

    $user->setIsSubscribed(0);
    
    $cancelMessage = 
        "<div class='alertSuccess'>
            Subscription successfully cancelled.
        </div>";

} else {

    $cancelMessage = 
        "<div class='alertError'>
            You are not currently subscribed!
        </div>";
}
?>
<div class="settingsContainer column">

    <div class="formSection">
        <?= $cancelMessage ?>
        <a href="profile.php">Back to Profile Page</a>
    </div>

</div>