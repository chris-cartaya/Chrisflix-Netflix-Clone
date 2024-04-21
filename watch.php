<?php
require_once("includes/header.php");

if (!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}

$video = new Video($con, $_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($con, $video);
?>
<div class="watchContainer">

    <div class="videoControls watchNav">
        <button onclick="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <h1><?= $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext">
        <button>
            <i class="fa-solid fa-arrow-rotate-right"></i>
        </button>

        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?= $upNextVideo->getTitle(); ?></h3>
            <h3><?= $upNextVideo->getSeasonAndEpisode(); ?></h3>

            <button class="playNext">
                <i class="fa-solid fa-play"></i> Play
            </button>
        </div>

    </div>

    <video controls autoplay>
        <source src="<?= $video->getFilePath(); ?>" type="video/mp4">
    </video>

</div>

<script>
    initVideo("<?= $video->getId(); ?>", "<?= $userLoggedIn ?>");
</script>