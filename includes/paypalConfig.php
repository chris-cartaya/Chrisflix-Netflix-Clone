<?php
require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        
        'AQNgDrcYil7PInhiBhZ2jqr-8-J__6Zt0V23EbhiLsgEHFMNP0sacxtqZSyQ7oZS3MwFjDZbMltCLu9k', // ClientID
        
        'EJKUlTDr-FJQaQ-38x0GBHzdRHH3d43tgywW4sKXkWUf9M1314emUTxV1dF4JK0Xtj8TpwRoG9h1I3kl'  // ClientSecret
    )
);
?>