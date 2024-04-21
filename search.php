<?php
require_once("includes/header.php");
?>
<div class="textBoxContainer">
    <input type="text" class="searchInput" placeholder="Search for something">
</div>

<div class="results"></div>

<script>

    $(function() {
        
        const username = "<?= $userLoggedIn; ?>";
        let timer;

        $(".searchInput").keyup(function() {
            clearTimeout(timer);

            timer = setTimeout(function() {
                let val = $(".searchInput").val();
                console.log(val);
            }, 500);
        })

    })

</script>