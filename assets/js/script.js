function volumeToggle(button) {
  const muted = $(".previewVideo").prop("muted");
  $(".previewVideo").prop("muted", !muted);

  // Remove mute icon and add volume-up icon
  $(button).find("i").toggleClass("fa-volume-xmark");
  $(button).find("i").toggleClass("fa-volume-high");
}

// When preview video finishes playing, display the image
function previewEnded() {
  $(".previewVideo").toggle();  // Hide video
  $(".previewImage").toggle();  // Show image
}

// Used to go back one page
function goBack() {
  window.history.back();
}

// Show/hide video title and back button on video player
function startHideTimer() {
  let timeout = null;
  
  $(document).on("mousemove", function() {
    clearTimeout(timeout);
    $(".watchNav").fadeIn();

    timeout = setTimeout(function() {
      $(".watchNav").fadeOut();
    }, 2000);
  });
}

// Initializes the video. Does any set up we want to do when the page loads.
function initVideo(videoID, userLoggedIn) {
  startHideTimer();
  console.log(videoID);
  console.log(userLoggedIn);
}