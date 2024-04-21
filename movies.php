<?php
require_once("includes/header.php");

$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createMoviesPreviewVideo();

$categories = new CategoryContainers($con, $userLoggedIn);
echo $categories->showMovieCategories();
?>